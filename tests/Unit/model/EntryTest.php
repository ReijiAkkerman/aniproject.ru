<?php
    namespace tests\Unit\model;

    use PHPUnit\Framework\TestCase;
    use project\model\Entry;

    class EntryTest extends TestCase {
        public function testGetTitle(): void {
            $obj = new Entry();

            $validSymbols = '-_ .,';
            $validData = 'taskname';
            $invalidSymbols = "!@#$%^&*()+=[]{}'\"<>|;:/?~`";
            $invalidData = 'taskname';

            for($i = 0; $i < strlen($validSymbols); $i++) {
                $_POST['title'] = $validData . $validSymbols[$i];
                $result = $obj->getTitle();
                $this->assertTrue($result);
            }

            for($i = 0; $i < strlen($invalidSymbols); $i++) {
                $_POST['title'] = $invalidData . $invalidSymbols[$i];
                $result = $obj->getTitle();
                $this->assertFalse($result);
            }
            $_POST['title'] = 'taskname\\';
            $result = $obj->getTitle();
            $this->assertFalse($result);
        }

        public function testGetDescription(): void {
            $obj = new Entry();

            $validSymbols = "!@%*()-_ /?.,:\"\n";
            $validData = 'taskname';
            $invalidSymbols = "~`#$^&=+[]{}'\\|;><";
            $invalidData = 'taskname';

            for($i = 0; $i < strlen($validSymbols); $i++) {
                $_POST['description'] = $validData . $validSymbols[$i];
                $result = $obj->getDescription();
                $this->assertTrue($result);
            }
            for($i = 0; $i < strlen($invalidSymbols); $i++) {
                $_POST['description'] = $invalidData . $invalidSymbols[$i];
                $result = $obj->getDescription();
                $this->assertFalse($result);
            }
        }

        public function testDefineDateTimeType(): void {
            $obj = new Entry();

            $_POST['without_time'] = 'on';
            $_POST['to_end_day'] = 'on';

            $result = $obj->defineDateTimeType();
            $actual_error = urldecode($obj->error_message);
            $expected_error = "Ошибка!!! Невозможно закончить задачу к концу дня которая не имеет времени на выполнение!!!";
            $this->assertFalse($result);
            $this->assertSame($expected_error, $actual_error);

            unset($_POST['to_end_day']);
            unset($obj->error_message);

            $result = $obj->defineDateTimeType();
            $this->assertSame('without_time', $result);

            $_POST['without_time'] = 'off';

            $result = $obj->defineDateTimeType();
            $actual_error = urldecode($obj->error_message);
            $expected_error = "Ошибка!!! Метка \"Без времени выполнения\" имеет недопустимое значение!!!";
            $this->assertFalse($result);
            $this->assertSame($expected_error, $actual_error);

            unset($_POST['without_time']);
            unset($obj->error_message);
            $_POST['to_end_day'] = 'on';
            
            $result = $obj->defineDateTimeType();
            $this->assertSame('to_end_day', $result);

            $_POST['to_end_day'] = 'off';
            
            $result = $obj->defineDateTimeType();
            $actual_error = urldecode($obj->error_message);
            $expected_error = "Ошибка!!! Метка \"До конца дня\" имеет недопустимое значение!!!";
            $this->assertFalse($result);
            $this->assertSame($expected_error, $actual_error);

            unset($_POST['to_end_day']);

            $result = $obj->defineDateTimeType();
            $this->assertSame('both', $result);
        }

        public function testValidateDateTimeValue(): void {
            $obj = new Entry();

            $types = [
                'start',
                'end'
            ];
            $labels = [
                'year',
                'month',
                'day',
                'hour',
                'minute'
            ];
            $caths = [
                'valid' => [
                    '2024', '11', '11', '20', '30',
                    '2024', '11', '11', '20', '35'
                ],
                'invalid_length' => [
                    '20240', '111', '111', '111', '111',
                    '20240', '111', '111', '111', '112'
                ],
                'invalid_value' => [
                    '0981', '13', '32', '24', '60',
                    '0981', '13', '32', '24', '62'
                ],
                'invalid_value_and_length' => [
                    '09810', '211', '411', '311', '711',
                    '09810', '211', '411', '311', '712'
                ]
            ];

            $counter = 0;

            foreach($caths as $cath) {
                for($i = 0, $j = 0, $k = 0; $i < sizeof($cath); $i++, $k++) {
                    if($i == 5) {
                        $j = 1;
                        $k = 0;
                    }
                    $type = $types[$j];
                    $label = $labels[$k];
                    $_POST[$type . '_' . $label] = $cath[$i];
                    switch($counter) {
                        case 0:
                            $result = $obj->validateDateTimeValue($type, $label);
                            $this->assertTrue($result);
                            break;
                        case 1:
                        case 3:
                            $result = $obj->validateDateTimeValue($type, $label);
                            $fieldName = $obj->getDateTimeFieldName($label);
                            $sectionName = $obj->getDateTimeSectionName($type);
                            $maxLength = $obj->getDateTimeMaxLength($label);
                            $expected_error = "Ошибка!!! Поле '$fieldName' в разделе '$sectionName' содержит более $maxLength символов!!!";
                            $actual_error = urldecode($obj->error_message);
                            $this->assertFalse($result);
                            $this->assertSame($expected_error, $actual_error);
                            break;
                        case 2:
                            $result = $obj->validateDateTimeValue($type, $label);
                            $fieldName = $obj->getDateTimeFieldName($label);
                            $expected_error = "Внимание! Поле '$fieldName' содержит недопустимые символы!";
                            $actual_error = urldecode($obj->error_message);
                            $this->assertFalse($result);
                            $this->assertSame($expected_error, $actual_error);
                            break;
                    }
                }
                $counter++;
            }
        }

        public function testGetDateTimeValues(): void {
            $obj = new Entry;

            $types = [
                'start',
                'end'
            ];
            $labels = [
                'year',
                'month',
                'day',
                'hour',
                'minute'
            ];
            $data = [
                '2023',
                '12',
                '12',
                '12',
                '23',
                '2023',
                '12',
                '12',
                '12',
                '30'
            ];
            for($i = 0; $i < sizeof($types); $i++) {
                for($j = 0; $j < sizeof($labels); $j++) {
                    $_POST[$types[$i] . '_' . $labels[$j]] = $data[$i*5+$j];
                }
            }

            $_POST['without_time'] = 'on';

            $result = $obj->getDateTimeValues();
            $this->assertTrue($result);
            $this->assertNull($obj->start);
            $this->assertNull($obj->end);

            $_POST['to_end_day'] = 'on';
            unset($_POST['without_time']);

            $result = $obj->getDateTimeValues();
            $this->assertTrue($result);
            $this->assertIsInt($obj->start);
            $this->assertIsInt($obj->end);

            unset($_POST['to_end_day']);

            $result = $obj->getDateTimeValues();
            $this->assertTrue($result);
            $this->assertIsInt($obj->start);
            $this->assertIsInt($obj->end);

            $_POST['end_minute'] = '10';

            $result = $obj->getDateTimeValues();
            $time_start = new \DateTimeImmutable();
            $start = $time_start->setTimestamp($obj->start);
            $time_end = new \DateTimeImmutable();
            $end = $time_end->setTimestamp($obj->end);
            $this->assertFalse($result);

            $_POST['end_minute'] = '100';

            $result = $obj->getDateTimeValues();
            $this->assertFalse($result);
        }
    }
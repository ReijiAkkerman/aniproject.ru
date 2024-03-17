<?php
    namespace tests\Unit\model;

    use PHPUnit\Framework\TestCase;
    use project\model\Entry;

    require_once __DIR__ . "/../../../vendor/autoload.php";

    class EntryTest extends TestCase {
        private function testGetTitle(): void {
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

        private function testGetDescription(): void {
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

        public function testGetDateTimeValues(): void {
            $obj = new Entry();

            $_POST['without_time'] = '';
            $_POST['to_end_day'] = '';

            $_POST['start_year'] = '2024';
            $_POST['start_month'] = '3';
            $_POST['start_day'] = '16';
            $_POST['start_hour'] = '15';
            $_POST['start_minute'] = '30';
            $_POST['end_year'] = '2024';
            $_POST['end_month'] = '3';
            $_POST['end_day'] = '16';
            $_POST['end_hour'] = '15';
            $_POST['end_minute'] = '35';

            $result = $obj->getDateTimeValues();
            $this->assertTrue($result);

            $_POST['without_time'] = 'on';

            $result = $obj->getDateTimeValues();
            $this->assertTrue($result);

            $_POST['to_end_day'] = 'on';

            $result = $obj->getDateTimeValues();
            $this->assertFalse($result);

            $_POST['without_time'] = '';

            $result = $obj->getDateTimeValues();
            $this->assertTrue($result);
        }

        public function testPrepareValues(): void {
            $obj = new Entry();

            $obj->without_time = false;
            $obj->to_end_day = true;

            $obj->prepareValues();
            $this->assertIsInt($obj->without_time);
            $this->assertIsInt($obj->to_end_day);
        }
    }
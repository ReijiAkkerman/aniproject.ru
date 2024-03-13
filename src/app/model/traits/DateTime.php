<?php
    namespace project\model\traits;

    use project\model\enum\Regex;

    trait DateTime {
        public function defineType(): string|false {
            if(isset($_POST['without_time']) && isset($_POST['to_end_day'])) {
                $this->error_message = urlencode("Ошибка!!! Невозможно закончить задачу к концу дня которая не имеет времени на выполнение!!!");
                return false;
            }
            else if(isset($_POST['without_time'])) {
                $regex = Regex::necessity;
                $valueMatches = preg_match($regex->value, $_POST['without_time']);
                if($valueMatches) {
                    $this->without_time = true;
                    return 'without_time';
                }
                else {
                    $this->error_message = urlencode("Ошибка!!! Метка \"Без времени выполнения\" имеет недопустимое значение!!!");
                    return false;
                }
            }
            else if(isset($_POST['to_end_day'])) {
                $regex = Regex::necessity;
                $valueMatches = preg_match($regex->value, $_POST['to_end_day']);
                if($valueMatches) {
                    $this->to_end_day = true;
                    return 'to_end_day';
                }
                else {
                    $this->error_message = urlencode("Ошибка!!! Метка \"До конца дня\" имеет недопустимое значение!!!");
                    return false;
                }
            }
            else {
                return 'both';
            }
        }

        public function validateValue(string $type, string $label): bool {
            $regex = $this->getRegex($label);
            $valueMatches = preg_match($regex->value, $_POST[$type . '_' . $label]);
            if($valueMatches) 
                return true;
            else {
                $max_length = $this->getMaxLength($label);
                $actual_length = strlen($_POST[$type . '_' . $label]);
                $fieldName = $this->getFieldName($label);
                $sectionName = $this->getSectionName($type);
                if($actual_length > $max_length) 
                    $this->error_message = urlencode("Ошибка!!! Поле '$fieldName' в разделе '$sectionName' содержит более $max_length символов!!!");
                else 
                    $this->error_message = urlencode("Внимание! Поле '$fieldName' содержит недопустимые символы!");
                return false;
            }
        }

        public function getValues(): bool {
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
            $input_type = $this->defineType();
            if($input_type) {
                switch($input_type) {
                    case 'both':
                        foreach($types as $type) {
                            foreach($labels as $label) {
                                $fieldValueIsGood = $this->validateValue($type, $label);
                                if($fieldValueIsGood == false)
                                    return false;
                            }
                        }
                        $this->start = mktime(
                            (int)$_POST[$types[0] . '_hour'],
                            (int)$_POST[$types[0] . '_minute'],
                            0,
                            (int)$_POST[$types[0] . '_month'],
                            (int)$_POST[$types[0] . '_day'],
                            (int)$_POST[$types[0] . '_year']
                        );
                        $this->end = mktime(
                            (int)$_POST[$types[1] . '_hour'],
                            (int)$_POST[$types[1] . '_minute'],
                            0,
                            (int)$_POST[$types[1] . '_month'],
                            (int)$_POST[$types[1] . '_day'],
                            (int)$_POST[$types[1] . '_year']
                        );
                        if($this->start > $this->end) {
                            $this->error_message = urlencode("Ошибка!!! Нельзя начать выполнение задачи после ее окончания!!!");
                            return false;
                        }
                        return true;
                        break;
                    case 'without_time':
                        $this->start = null;
                        $this->end = null;
                        return true;
                        break;
                    case 'to_end_day':
                        foreach($labels as $label) {
                            $fieldValueIsGood = $this->validateValue($types[0], $label);
                            if($fieldValueIsGood == false) 
                                return false;
                        }
                        $this->start = mktime(
                            (int)$_POST[$types[0] . '_hour'],
                            (int)$_POST[$types[0] . '_minute'],
                            0,
                            (int)$_POST[$types[0] . '_month'],
                            (int)$_POST[$types[0] . '_day'],
                            (int)$_POST[$types[0] . '_year']
                        );
                        $this->end = mktime(
                            23,
                            59,
                            59,
                            (int)$_POST[$types[1] . '_month'],
                            (int)$_POST[$types[1] . '_day'],
                            (int)$_POST[$types[1] . '_year']
                        );
                        if($this->start > $this->end) {
                            $this->error_message = urlencode("Ошибка!!! Нельзя начать выполнение задачи после ее окончания!!!");
                            return false;
                        }
                        return true;
                        break;
                }
            }
        }

        public function getMaxLength(string $label): int {
            $length = match($label) {
                'year' => 4,
                'month' => 2,
                'day' => 2,
                'hour' => 2,
                'minute' => 2
            };
            return $length;
        }

        public function getFieldName(string $label): string {
            $fieldName = match($label) {
                'year' => 'Год',
                'month' => 'Месяц',
                'day' => 'День',
                'hour' => 'Час',
                'minute' => 'Минута'
            };
            return $fieldName;
        }

        public function getSectionName(string $type): string {
            $sectionName = match($type) {
                'start' => 'Начало',
                'end' => 'Конец'
            };
            return $sectionName;
        }
    }
<?php
    namespace project\model\traits;

    use project\model\enum\Regex;

    trait DateTime {
        public array $dateTimeLabels = [
            'year',
            'month',
            'day',
            'hour',
            'minute'
        ];
        public array $dateTimeTypes = [
            'start',
            'end'
        ];

        public function getValues(): bool {
            $Type = $this->defineType();
            $this->created = time();
            if($Type) {
                switch($Type) {
                    case 'without_time':
                        $this->without_time = true;
                        $this->to_end_day = false;
                        $this->start = 0;
                        $this->end = 0;
                        return true;
                        break;
                    case 'to_end_day':
                        foreach($this->dateTimeLabels as $label) {
                            $regex = $this->getRegex($label);
                            $valueMatches = $this->validateValue($regex, $_POST['start_' . $label]);
                            if(!$valueMatches)
                                return false;
                        }
                        $this->without_time = false;
                        $this->to_end_day = true;
                        $this->start = mktime(
                            (int)$_POST['start_hour'],
                            (int)$_POST['start_minute'],
                            0,
                            (int)$_POST['start_month'],
                            (int)$_POST['start_day'],
                            (int)$_POST['start_year']
                        );
                        $this->end = mktime(
                            23,
                            59,
                            59,
                            (int)$_POST['start_month'],
                            (int)$_POST['start_day'],
                            (int)$_POST['start_year']
                        );
                        return true;
                        break;
                    case 'both':
                        foreach($this->dateTimeTypes as $type) {
                            foreach($this->dateTimeLabels as $label) {
                                $regex = $this->getRegex($label);
                                $valueMatches = $this->validateValue($regex, $_POST[$type . '_' . $label]);
                                if(!$valueMatches)
                                    return false;
                            }
                        }
                        $this->without_time = false;
                        $this->to_end_day = false;
                        $this->start = mktime(
                            (int)$_POST['start_hour'],
                            (int)$_POST['start_minute'],
                            0,
                            (int)$_POST['start_month'],
                            (int)$_POST['start_day'],
                            (int)$_POST['start_year']
                        );
                        $this->end = mktime(
                            (int)$_POST['end_hour'],
                            (int)$_POST['end_minute'],
                            0,
                            (int)$_POST['end_month'],
                            (int)$_POST['end_day'],
                            (int)$_POST['end_year']
                        );
                        return true;
                        break;
                }
            }
            else 
                return false;
        }

        private function defineType(): string|false {
            $without_time = isset($_POST['without_time']) && $_POST['without_time'];
            $to_end_day = isset($_POST['to_end_day']) && $_POST['to_end_day'];
            if($without_time && $to_end_day) {
                $this->error_message = urlencode("Ошибка!!! Задача без времени выполнения не может выполняться до конца дня!!!");
                return false;
            }
            else if($without_time) {
                return 'without_time';
            }
            else if($to_end_day) {
                return 'to_end_day';
            }
            else 
                return 'both';
        }

        private function validateValue(Regex $regex, string $data): bool {
            $result = preg_match($regex->value, $data);
            return $result;
        }
    }
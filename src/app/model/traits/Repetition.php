<?php
    namespace project\model\traits;

    use project\model\enum\Regex;

    trait Repetition {
        private array $mainRepetitions = [
            'every_day',
            'every_month',
            'every_week',
            'every_year',
            'interval'
        ];
        private string $lastMainRepetition;

        public function getValues(): bool {
            $this->repetition_main = '';
            $this->repetition_addition = '';
            $mainTypesNumber = $this->getMainTypesNumber();
            if($mainTypesNumber !== false) {
                $this->repetition_main = $this->lastMainRepetition;
                if($mainTypesNumber) {
                    switch($this->lastMainRepetition) {
                        case 'every_week':
                            $additionalTypes = [
                                'monday',
                                'tuesday',
                                'wednesday',
                                'thursday',
                                'friday',
                                'saturday',
                                'sunday'
                            ];
                            foreach($additionalTypes as $type) {
                                if(isset($_POST[$type]) && $_POST[$type]) {
                                    $regex = Regex::weekday;
                                    $valueMatches = preg_match($regex->value, $_POST[$type]);
                                    if($valueMatches)
                                        $this->repetition_addition .= $_POST[$type] . ',';
                                    else 
                                        return false;
                                }
                            }
                            if($this->repetition_addition)
                                $this->repetition_addition = rtrim($this->repetition_addition, ',');
                            break;
                        case 'interval':
                            $additionalTypes = [
                                'year',
                                'month',
                                'day',
                                'hour',
                                'minute'
                            ];
                            $areAllFields = function() use($additionalTypes) {
                                $areAllFields = true;
                                foreach($additionalTypes as $type) {
                                    if(!isset($_POST['interval_' . $type]))
                                        $areAllFields = false;
                                }
                                return $areAllFields;
                            };
                            $allFieldsAreSet = $areAllFields();
                            if($allFieldsAreSet) {
                                $set_time = false;
                                if(isset($_POST['set_time']) && $_POST['set_time'])
                                    $set_time = true;
                                if($set_time) {
                                    foreach($additionalTypes as $type) {
                                        $regex = $this->getRegex($type);
                                        $valueMatches = preg_match($regex->value, $_POST['interval_' . $type]);
                                        if($valueMatches) 
                                            $this->repetition_addition .= $_POST['interval_' . $type] . ',';
                                        else 
                                            return false;
                                    }
                                    $this->repetition_addition = rtrim($this->repetition_addition, ',');
                                }
                                else {
                                    for($i = 0; $i < 3; $i++) {
                                        $type = $additionalTypes[$i];
                                        $regex = $this->getRegex($type);
                                        $valueMatches = preg_match($regex->value, $_POST['interval_' . $type]);
                                        if($valueMatches)
                                            $this->repetition_addition .= $_POST['interval_' . $type] . ',';
                                        else 
                                            return false;
                                    }
                                    $this->repetition_addition .= '0,0';
                                }
                            }
                            else 
                                return false;
                            break;
                    }
                    return true;
                }
                else 
                    return true;
            }
            else 
                return false;
        }

        private function getMainTypesNumber(): int|false {
            $mainRepetitionsNumber = 0;
            foreach($this->mainRepetitions as $type) {
                if(isset($_POST[$type])) {
                    $mainRepetitionsNumber++;
                    $this->lastMainRepetition = $type;
                }
            }
            return match($mainRepetitionsNumber) {
                0 => 0,
                1 => 1,
                default => false
            };
        }
    }
<?php
    namespace project\model;

    use project\model\abstract\iEntry;
    use project\model\traits\DateTime;
    use project\model\enum\Regex;

    class Entry implements iEntry {
        public string $title;
        public string $description;
        public ?int $start;
        public int $created;
        public ?int $end;
        public ?bool $without_time;
        public ?bool $to_end_day;
        public string $repetition;
        public string $cathegory;
        public string $task_nesting;
        public string $users;
        public string $materials;
        public string $parent;
        public string $direct_descendants;

        public string $error_message;



        public function getEntries(): array|false {

        }

        public function saveEntries(): bool {

        }

        public function deleteEntries(): bool {

        }

        public function updateEntries(): bool {

        }





        /**
         * Проверяет заголовок на отсутствие недопустимых символов и
         * сохраняет его в свойства
         */

        public function getTitle(): bool {
            if(isset($_POST['title'])) {
                $regex = Regex::title;
                $valueMatches = preg_match($regex->value, $_POST['title']);
                if($valueMatches) {
                    $this->title = $_POST['title'];
                    return true;
                }
                else 
                    return false;
            }
            else 
                return false;
        }

        public function getDescription(): bool {
            if(isset($_POST['description'])) {
                $regex = Regex::description;
                $valueMatches = preg_match($regex->value, $_POST['description']);
                if($valueMatches) {
                    $this->description = $_POST['description'];
                    return true;
                }
                else 
                    return false;
            }
            else 
                return false;
        }

        use DateTime {
            DateTime::defineType as defineDateTimeType;
            DateTime::validateValue as validateDateTimeValue;
            DateTime::getValues as getDateTimeValues;
            DateTime::getMaxLength as getDateTimeMaxLength;
            DateTime::getFieldName as getDateTimeFieldName;
            DateTime::getSectionName as getDateTimeSectionName;
        }

        public function getRegex(string $name): Regex|false {
            $regex = match($name) {
                'title' => Regex::title,
                'description' => Regex::description,
                'year' => Regex::year,
                'month' => Regex::month,
                'day' => Regex::day,
                'hour' => Regex::hour,
                'minute' => Regex::minute,
                'necessity' => Regex::necessity,
                'weekday' => Regex::weekday,
                'cath' => Regex::cath,
                'task_nesting' => Regex::task_nesting,
                'user' => Regex::user,
                default => false
            };
            return $regex;
        }
    }
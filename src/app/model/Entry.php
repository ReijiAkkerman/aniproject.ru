<?php
    namespace project\model;

    use project\control\parent\Page;
    use project\model\abstract\iEntry;
    use project\model\traits\DateTime;
    use project\model\traits\Repetition;
    use project\model\traits\Cath_n_Task;
    use project\model\traits\Users;
    use project\model\enum\Regex;

    class Entry implements iEntry {
        public string $title;
        public string $description;
        public int $start;
        public int $created;
        public int $end;
        public bool $without_time;
        public bool $to_end_day;
        public string $repetition_main;
        public string $repetition_addition;
        public string $cathegory;
        public string $task_nesting;
        public string $users;
        public string $materials;
        public string $parent;
        public string $direct_descendants;

        public string $error_message;

        private array $functions;

        public function __construct() {
            $this->functions = [
                'getTitle',
                'getDescription',
                'getDateTimeValues',
                'getRepetitionValues'
            ];
        }

        public function getEntries(): void {

        }

        public function saveEntries(): void {
            $isGood = $this->checkFunctions();
            if($isGood) {
                $without_time = (int)$this->without_time;
                $to_end_day = (int)$this->to_end_day;

                $mysql = new \mysqli(Page::$server, 'Entries', 'kISARAGIeKI4', 'Entries');
                $query = "INSERT INTO ReijiAkkerman(
                    title,
                    description,
                    creation_time,
                    start_time,
                    end_time,
                    without_time,
                    to_end_day,
                    repetition_main,
                    repetition_addition,
                    cathegory,
                    task_nesting,
                    related_users,
                    materials,
                    parent,
                    direct_descendants
                ) VALUES (
                    '{$this->title}',
                    '{$this->description}',
                    {$this->created},
                    {$this->start},
                    {$this->end},
                    $without_time,
                    $to_end_day,
                    '{$this->repetition_main}',
                    '{$this->repetition_addition}',
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                )";
                $mysql->query($query);
                $mysql->close();
                echo 'successful';
            }
            else 
                echo 'not successful';
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
            DateTime::getValues insteadOf Repetition;

            DateTime::getValues as getDateTimeValues;
            DateTime::defineType as defineDateTimeType;
            DateTime::validateValue as validateDateTimeValue;
        }

        use Repetition {
            Repetition::getValues as getRepetitionValues;
            Repetition::getMainTypesNumber as getRepetitionMainTypesNumber;
        }

        private function checkFunctions(): bool {
            for($i = 0; $i < sizeof($this->functions); $i++) {
                $functionName = $this->functions[$i];
                $true = $this->$functionName();
                if(!$true) {
                    return false;
                }
            }
            return true;
        }

        private function getRegex(string $name): Regex|false {
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
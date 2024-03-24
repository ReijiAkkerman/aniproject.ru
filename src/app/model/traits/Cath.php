<?php
    namespace project\model\traits;

    use project\model\enum\Regex;

    trait Cath {
        public function getValues(): bool {
            $new_cath = $this->isNewCath();
            $recent_type = $this->areRecentCaths();
            if($new_cath && $recent_type) {
                $this->error_message .= urlencode("Ошибка!!! Одновременно не может быть указаны и новая и существующая категория!!!");
                return false;
            }
            else if($recent_type) 
                return true;
            else if($new_cath) 
                return true;
            else {
                $this->cathegory = 'none';
                return true;
            }
        }

        public function isNewCath(): bool {
            if($_POST['new_cath']) {
                $regex = Regex::cath;
                $valueMatches = preg_match($regex->value, $_POST['new_cath']);
                if($valueMatches) {
                    $this->cathegory = $_POST['new_cath'];
                    return true;
                }
                else 
                    return false;
            }
            else 
                return false;
        }

        public function areRecentCaths(): int|false {
            $types_number = 0;
            for($i = 0; $i < 5; $i++) {
                if(isset($_POST['cath' . $i]) && $_POST['cath' . $i]) {
                    $types_number++;
                    $lastRecentCath = $_POST['cath' . $i];
                }
            }
            if($types_number > 1) {
                $this->error_message .= urlencode("Внимание! Выбрать можно только одну из категорий!");
                return false;
            }
            else if($types_number) {
                $regex = Regex::cath;
                $valueMatches = preg_match($regex->value, $lastRecentCath);
                if($valueMatches) {
                    $this->cathegory = $lastRecentCath;
                    return $types_number;
                }
                else {
                    $this->error_message .= urlencode("Внимание! Наименование категории содержит неверные символы или длину!");
                    return false;
                }
            }
            else
                return $types_number;
        }
    }
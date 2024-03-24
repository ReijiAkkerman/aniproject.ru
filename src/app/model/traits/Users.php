<?php
    namespace project\model\traits;

    use project\model\enum\Regex;

    trait Users {
        public function getValues(): bool {
            $this->users = '';
            $newUser = $this->isNewUser();
            $recentUsers = $this->areRecentUsers();
            if($newUser !== false && $recentUsers !== false) 
                return true;
            else 
                return false;
        }

        public function isNewUser(): int|false {
            if($_POST['new_user']) {
                $regex = Regex::users;
                $valueMatches = preg_match($regex->value, $_POST['new_user']);
                if($valueMatches) {
                    $this->users .= $_POST['new_user'];
                    return 1;
                }
                else {
                    $this->error_message .= urlencode("Внимание! Поле 'Новый пользователь' содержит недопустимые символы или длину!");
                    return false;
                }
            }
            else 
                return 0;
        }

        public function areRecentUsers(): int|false {
            for($i = 0; $i < 5; $i++) {
                if(isset($_POST['user' . $i]) && $_POST['user' . $i]) {
                    $regex = Regex::users;
                    $valueMatches = preg_match($regex->value, $_POST['user' . $i]);
                    if($valueMatches) {
                        $this->users .= ',' . $_POST['user' . $i];
                        return 1;
                    }
                    else {
                        $this->error_message .= urlencode("Ошибка!!! Указанные пользователи имеют недопустимые символы или длину!!!");
                        return false;
                    }
                }
            }
            return 0;
        }
    }
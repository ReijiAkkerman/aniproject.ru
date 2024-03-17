<?php
    namespace project\control;

    use project\control\enum\Regex;
    use project\control\parent\Page;
    use project\control\traits\ViewPage;
    use project\control\traits\Access;

    class Log extends Page {
        public string $login;
        public string $password;
        public string $loginType;
        public array $fields;
        public string $error_message;

        use ViewPage;
        use Access;

        public function __construct() {
            $this->constructor();
            $this->fields = [
                'login',
                'password'
            ];
            $this->error_message = '';
        }

        public function login(): void {
            $goodFieldsNames = $this->checkFieldsNames();
            if($goodFieldsNames) {
                $goodFieldsContent = $this->checkFieldsContent();
                if($goodFieldsContent) {
                    $verifiedFieldsContent = $this->verifyFieldsContent();
                    if($verifiedFieldsContent) {
                        $this->getFieldsContent();
                        $isUser = $this->isUser($this->login, $this->loginType, $this->server);
                        if($isUser) {
                            $rightPassword = $this->comparePassword($this->login, $this->password, $this->loginType, $this->server);
                            if($rightPassword) {
                                $this->sendCookie($this->server);
                                header("Location: ../calendar/view");
                                exit;
                            }
                            else 
                                goto end_of_function;
                        }
                        else 
                            goto end_of_function;
                    }
                    else 
                        goto end_of_function;
                }
                else 
                    goto end_of_function;
            }
            else {
                end_of_function:
                    header("Location: ../error/view?error_message={$this->error_message}");
                    exit;
            }
        }





        public function sendCookie(string $server = 'localhost'): void {
            $this->userID = $this->getUserID($this->login, $this->loginType, $server);
            $this->getAccessToken($server);
            setcookie('ID', $this->userID, time() + $this->activityTime, '/');
            setcookie('token', $this->accessToken, time() + $this->activityTime, '/');
        }

        public function comparePassword(
            string $login,
            string $password,
            string $loginType,
            string $server = 'localhost'
        ): bool {
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "SELECT password FROM users WHERE $loginType='$login'";
            $result = $mysql->query($query);
            foreach($result as $row) {
                $password_in_DB = $row['password'];
            }
            $isGood = password_verify($password, $password_in_DB);
            if($isGood) 
                return true;
            else {
                $this->error_message .= urlencode("Внимание! Указанный пароль не верный!\n");
                return false;
            }
        }

        public function isUser(
            string $login,
            string $loginType,
            string $server = 'localhost'
        ): bool {
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "SELECT login FROM users WHERE $loginType='$login'";
            $result = $mysql->query($query);
            $mysql->close();
            if($result->num_rows == 1) 
                return true;
            else {
                $this->error_message .= urlencode("Внимание! Указанный пользователь не найден!\n");
                return false;
            }
        }

        public function getFieldsContent(): void {
            foreach($this->fields as $row) {
                $this->$row = $_POST[$row];
            }
        }

        public function verifyFieldsContent(): bool {
            $formats = [
                'login' => '',
                'password' => 'password'
            ];
            $this->loginType = $formats['login'] = $this->defineLoginType($_POST['login']);
            $isGood = true;
            foreach($formats as $key => $value) {
                $regex = $this->getRegex($value);
                $verified = preg_match($regex->value, $_POST[$key]);
                if(!$verified) {
                    $isGood = false;
                    $fieldLabel = $this->getFieldLabel($key);
                    $this->error_message .= urlencode("Внимание! Поле '$fieldLabel' содержит недопустимые символы или длину!\n");
                }
            }
            return $isGood;
        }

        public function checkFieldsContent(): bool {
            $isGood = true;
            for($i = 0; $i < sizeof($this->fields); $i++) {
                $fieldName = $this->fields[$i];
                if(!$_POST[$fieldName]) {
                    $isGood = false;
                    $fieldLabel = $this->getFieldLabel($fieldName);
                    $this->error_message .= urlencode("Внимание! Поле '$fieldLabel' не заполнено!\n");
                }
            }
            return $isGood;
        }

        public function checkFieldsNames(): bool {
            $isGood = true;
            for($i = 0; $i < sizeof($this->fields); $i++) {
                $fieldName = $this->fields[$i];
                if(!isset($_POST[$fieldName])) {
                    $isGood = false;
                    $fieldLabel = $this->getFieldLabel($fieldName);
                    $this->error_message .= urlencode("Ошибка!!! Данные от поля '$fieldLabel' не получены!!!\n");
                }
            }
            return $isGood;
        }





        public function getUserID(string $login, string $loginType, string $server = 'localhost'): int {
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "SELECT ID FROM users WHERE $loginType='$login'";
            $result = $mysql->query($query);
            $mysql->close();
            foreach($result as $row) {
                return $row['ID'];
            }
        }

        public function getFieldLabel(string $fieldName): string|false {
            $fieldLabel = match($fieldName) {
                'login' => 'Логин',
                'password' => 'Пароль',
                default => false 
            };
            return $fieldLabel;
        }

        public function getRegex(string $format): Regex|false {
            $regex = match($format) {
                'email' => Regex::email,
                'login' => Regex::login,
                'password' => Regex::password,
                default => false
            };
            return $regex;
        }

        public function defineLoginType(string $login): string {
            $isEmail = str_contains($login, '@');
            if($isEmail) 
                return 'email';
            else 
                return 'login';
        }
    }
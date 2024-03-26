<?php
    namespace project\control;

    use project\control\enum\Regex;
    use project\control\parent\Page;
    use project\control\traits\ViewPage;
    use project\control\traits\Access;

    class Reg extends Page {
        public array $fields;
        public string $email;
        public string $login;
        public string $name;
        public string $password;
        public string $accessToken;
        public bool $async;
        public string $error_message;

        public function __construct() {
            $this->constructor();
            $this->error_message = '';
        }





        use ViewPage;
        use Access;

        public function registrateUser(): void {
            $fieldsAreGood = $this->getFieldValues();
            if($fieldsAreGood) {
                $newUser = $this->isNewUser(Page::$server, Page::$connect_from);
                if($newUser) {
                    $this->createAccessToken(Page::$server);
                    $this->registrate(Page::$server);
                    $this->sendCookie(Page::$server);
                    header("Location: ../calendar/view");
                    exit;
                }
                else {
                    header("Location: ../error/view?error_message={$this->error_message}");
                    exit;
                }
            }
            else {
                header("Location: ../error/view?error_message={$this->error_message}");
                exit;
            }
        }





        public function sendCookie(string $server = 'localhost'): void {
            $userID = $this->getUserID($server);
            setcookie('ID', $userID, time() + $this->activityTime, '/');
            setcookie('token', $this->accessToken, time() + $this->activityTime, '/');
        }
        
        private function isNewUser(string $server = 'localhost', string $connect_from = 'localhost'): bool {
            try {
                $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            }
            catch(\mysqli_sql_exception $exception) {
                $this->init($server, $connect_from);
                return true;
            }
            $query = "SELECT email,login FROM users WHERE email='{$this->email}' || login='{$this->login}'";
            $result = $mysql->query($query);
            if($result->num_rows) {
                if($result->num_rows > 1) {
                    $this->error_message .= urlencode("Ошибка!!! Уникальные поля содержат одинаковые данные!!!\n");
                    return false;
                }
                else {
                    foreach($result as $row) {
                        if($this->email == $row['email'])
                            $this->error_message .= urlencode("Внимание! Указанная почта уже используется!\n");
                        if($this->login == $row['login'])
                            $this->error_message .= urlencode("Внимание! Указанный логин уже занят!\n");
                    }
                    return false;
                }
            } 
            else 
                return true;
        }
        
        private function registrate(string $server = 'localhost'): void {
            $reg_time = time();
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "INSERT INTO users(
                email,
                login,
                name,
                password,
                registration_time,
                last_enter_time,
                users,
                access_token,
                recent_users
            ) VALUES (
                '{$this->email}',
                '{$this->login}',
                '{$this->name}',
                '{$this->password}',
                $reg_time,
                $reg_time,
                null,
                '{$this->accessToken}',
                null
            )";
            $mysql->query($query);
            $mysql->close();
            $mysql = new \mysqli($server, 'Entries', 'kISARAGIeKI4', 'Entries');
            $query = "CREATE TABLE IF NOT EXISTS {$this->login}(
                ID SERIAL,
                title VARCHAR(255),
                description TEXT,
                creation_time INT,
                start_time INT,
                end_time INT,
                without_time BOOLEAN,
                to_end_day BOOLEAN,
                repetition_main VARCHAR(100),
                repetition_addition VARCHAR(100),
                repetition_upto INT,
                cathegory VARCHAR(255),
                task_nesting TEXT,
                related_users TEXT,
                materials TEXT,
                parent VARCHAR(255),
                direct_descendants TEXT
            )";
            $mysql->query($query);
            $mysql->close();
            $mysql = new \mysqli($server, 'Words', 'kISARAGIeKI4', 'Words');
            $query = "CREATE TABLE IF NOT EXISTS {$this->login}(
                ID SERIAL,
                words TEXT,
                server VARCHAR(255),
                branch VARCHAR(255),
                creation_time INT,
                study_start INT,
                study_end INT
            )";
            $mysql->query($query);
            $mysql->close();
        }
        
        public function init(string $server = 'localhost', string $connect_from = 'localhost'): void {
            $mysql = new \mysqli($server, 'root', 'KisaragiEki4');
            $databases = [
                "Users",
                "Entries",
                "Words"
            ];
            foreach($databases as $database) {  
                $queries = [
                    "CREATE DATABASE IF NOT EXISTS $database",
                    "CREATE USER IF NOT EXISTS '$database'@'$connect_from' IDENTIFIED WITH mysql_native_password BY 'kISARAGIeKI4'",
                    "GRANT SELECT, UPDATE, INSERT, DELETE, DROP, CREATE ON {$database}.* TO '$database'@'$connect_from'"
                ];
                foreach($queries as $query) {
                    $mysql->query($query);
                }
            }
            $query = "USE Users";
            $mysql->query($query);
            $query = "CREATE TABLE IF NOT EXISTS users(
                ID SERIAL,
                email VARCHAR(255) UNIQUE,
                login VARCHAR(255) UNIQUE,
                name VARCHAR(255),
                password VARCHAR(255),
                registration_time INT,
                last_enter_time INT, 
                users TEXT,
                access_token VARCHAR(255),
                recent_users TEXT 
            )";
            $mysql->query($query);
            $query = "REVOKE CREATE, DROP ON Users.* FROM 'Users'@'$connect_from'";
            $mysql->query($query);
            $mysql->close();
        }

        public function getUserID(string $server = 'localhost'): int {
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "SELECT ID FROM users WHERE login='{$this->login}'";
            $result = $mysql->query($query);
            if($result->num_rows)
                foreach($result as $row) {
                    return $row['ID'];
                }
            else 
                return false;
        }





        public function getFieldValues(): bool {
            $this->fields = [
                'email',
                'login',
                'name',
                'password1',
                'password2'
            ];
            $fieldsAreGood = true;
            for($i = 0; $i < sizeof($this->fields); $i++) {
                $good = $this->isGoodField($this->fields[$i]);
                if(!$good)
                    $fieldsAreGood = false;
            }
            if($fieldsAreGood) {
                $this->password = $this->getPassword();
                if($this->password) {
                    $this->email = $_POST['email'];
                    $this->login = $_POST['login'];
                    $this->name = $_POST['name'];
                    return true;
                }
                else 
                    return false;
            }
            else 
                return false;
        }
        
        public function isGoodField(string $field): bool {
            if(isset($_POST[$field])) {
                if($_POST[$field]) {
                    if($field == 'password1' || $field == 'password2')
                        $regex = $this->getRegex('password');
                    else 
                        $regex = $this->getRegex($field);
                    $matched = preg_match($regex->value, $_POST[$field]);
                    if($matched) 
                        return true;
                    else {
                        $fieldName = $this->getFieldName($field);
                        $this->error_message .= urlencode("Внимание! Поле '$fieldName' имеет недопустимые символы или длину!\n");
                        return false;
                    }
                }
                else {
                    $fieldName = $this->getFieldName($field);
                    $this->error_message .= urlencode("Внимание! Поле '$fieldName' не заполнено!\n");
                    return false;
                }
            }
            else {
                $fieldName = $this->getFieldName($field);
                $this->error_message .= urlencode("Ошибка!!! Поле '$fieldName' не найдено!!!\n");
                return false;
            }
        }

        public function getFieldName(string $name): string|false {
            $string = match($name) {
                'email' => 'E-mail',
                'login' => 'Логин',
                'name' => 'Имя',
                'password1' => 'Пароль',
                'password2' => 'Повтор',
                default => false
            };
            return $string;
        }

        public function getRegex(string $name): Regex|false {
            $regex = match($name) {
                'email' => Regex::email,
                'login' => Regex::login,
                'name' => Regex::name,
                'password' => Regex::password,
                default => false
            };
            return $regex;
        }

        public function getPassword(): string|false {
            $password = $this->comparePasswords($_POST['password1'], $_POST['password2']);
            if($password) {
                $hashed_password = $this->encryptPassword($password);
                return $hashed_password;
            }
            else 
                return false;
        }

        public function comparePasswords(string $password1, string $password2): string|false {
            if($password1 === $password2) 
                return $password1;
            else {
                $this->error_message .= urlencode("Внимание! Пароли не совпадают!\n");
                return false;
            }
        }

        public function encryptPassword(string $password): string {
            $password = password_hash($password, PASSWORD_DEFAULT);
            return $password;
        }
    }
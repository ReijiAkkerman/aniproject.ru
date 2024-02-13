<?php
    namespace project\control;

    require_once __DIR__ . "/abstract/Page.php";

    require_once __DIR__ . "/traits/ViewPage.php";
    require_once __DIR__ . "/traits/ValidateUser.php";

    use project\control\enum\Regex;

    class Reg extends Page {
        public array $fields;
        public string $email;
        public string $login;
        public string $name;
        public string $password;
        public bool $async;
        public string $error_message;

        public function __construct() {
            $this->error_message = '';
        }





        use ViewPage;

        public function registrateUser(): void {
            $this->getFieldValues();
            if($this->error_message) 
                header("Location: ../error/view?error_message={$this->error_message}");
            else {
                $is_user = $this->isUser();
                if($is_user) {
                    header("Location: ../error/view?");
                }
                else {
                    $this->registrate();
                    header("Location: ../calendar/view");
                }
            }
        }




        
        public function isUser($server = 'localhost'): bool {
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "SELECT email,login FROM users WHERE email='{$this->email}' && login='{$this->login}'";
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
        
        public function registrate(string $server = 'localhost'): void {
            $reg_time = time();
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "INSERT INTO users(
                email,
                login,
                name,
                password,
                registration_time,
                last_enter_time,
                groups_users
            ) VALUES (
                '{$this->email}',
                '{$this->login}',
                '{$this->name}',
                '{$this->password}',
                $reg_time,
                $reg_time,
                'none'
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
                repetition VARCHAR(1000),
                cathegory VARCHAR(255),
                related_users TEXT
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
                email VARCHAR(255),
                login VARCHAR(255),
                name VARCHAR(255),
                password VARCHAR(255),
                registration_time INT,
                last_enter_time INT, 
                groups_users TEXT
            )";
            $mysql->query($query);
            $query = "REVOKE CREATE, DROP ON Users.* FROM 'Users'@'$connect_from'";
            $mysql->query($query);
            $mysql->close();
        }
        
        public function defineRequestType(): bool {

        }
        
        private function getFieldValues(): bool {
            $this->fields = [
                'email',
                'login',
                'name',
                'password1',
                'password2'
            ];
            $values = $this->getValues();
            if($values){
                $this->email = $values['email'];
                $this->login = $values['login'];
                $this->name = $values['name'];
                $this->password = $this->getPassword($values['password1'], $values['password2']);
                return true;
            }
            else {
                $this->error_message .= urlencode("Внимание! Введенные данные содержат недопустимые символы!\n");
                return false;
            }
        }

        private function getValues(): array|false {
            $array = [];
            for($i = 0; $i < sizeof($this->fields); $i++) {
                if($this->fields[$i] == 'password1') {
                    $prop = $this->fields[$i];
                    $i++;
                    $func = $this->getRegex('password');
                    $array[$prop] = $this->validateField($func, $_POST[$prop]);
                    $array[$this->fields[$i]] = $this->validateField($func, $_POST[$this->fields[$i]]);
                }
                else {
                    $prop = $this->fields[$i];
                    $func = $this->getRegex($prop);
                    $array[$prop] = $this->validateField($func, $_POST[$prop]);
                }
            }
            if(!in_array(false, $array, true))
                return $array;
            else 
                return false;
        }

        private function validateField(Regex $func, string $field_value = ''): string|false {
            $regex = $func->value;
            if($field_value)
                if(preg_match($regex, $field_value))
                    return $field_value;
                else 
                    return false;
            else 
                return false;
        }

        private function getRegex(string $field): Regex|false {
            $regex = match($field) {
                'email' => Regex::email,
                'login' => Regex::login,
                'name' => Regex::name,
                'password' => Regex::password,
                default => false
            };
            return $regex;
        }



        private function getPassword(string $password1, string $password2): string|false {
            $clear_password = $this->comparePasswords($password1, $password2);
            if($clear_password) {
                $password = $this->encryptPassword($clear_password);
                return $password;
            }
            else 
                return false;
        }

        private function comparePasswords(string $password1 = '', string $password2 = ''): string|false {
            if($password1 && $password2) 
                if($password1 === $password2) 
                    return $password1;
                else 
                    return false;
            else 
                return false;
        }

        private function encryptPassword(string $password): string {
            $password = password_hash($password, PASSWORD_DEFAULT);
            return $password;
        }
    }
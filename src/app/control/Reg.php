<?php
    namespace project\control;

    require_once __DIR__ . "/abstract/Page.php";

    require_once __DIR__ . "/traits/ViewPage.php";
    require_once __DIR__ . "/traits/ValidateUser.php";

    class Reg extends Page {
        public string $email;
        public string $login;
        public string $name;
        public string $password;

        public function __construct() {
            $this->email = $_POST['email'];
            $this->login = $_POST['login'];
            $this->name = $_POST['name'];
            $this->password = $this->getPassword();
        }

        use ViewPage;

        public function registrate($server = 'localhost'): void {
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4');
            $query = "INSERT INTO";
        }

        public function init(string $server = 'localhost'): void {
            $mysql = new \mysqli($server, 'root', 'KisaragiEki4');
            $databases = [
                "Users",
                "Entries",
                "Words"
            ];
            foreach($databases as $database) {  
                $queries = [
                    "CREATE DATABASE IF NOT EXISTS $database",
                    "CREATE USER IF NOT EXISTS '$database'@'$server' IDENTIFIED BY 'kISARAGIeKI4'",
                    "GRANT SELECT, UPDATE, INSERT, DELETE, DROP, CREATE ON {$database}.* TO '$database'@'$server'"
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
            $query = "REVOKE CREATE, DROP ON Users.* FROM 'Users'@'$server'";
            $mysql->query($query);
            $mysql->close();
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

        private function getPassword(string $password1, string $password2): string|false {
            $clear_password = $this->comparePasswords($password1, $password2);
            if($clear_password) {
                $password = $this->encryptPassword($clear_password);
                return $password;
            }
            else 
                return false;
        }
    }
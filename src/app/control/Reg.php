<?php
    namespace project\control;

    require_once __DIR__ . "/abstract/Page.php";

    require_once __DIR__ . "/traits/ViewPage.php";
    require_once __DIR__ . "/traits/ValidateUser.php";

    class Reg extends Page {
        use ViewPage;

        public function __construct() {

        }

        public function registrate() {
            
        }

        private function init() {
            $mysql = new \mysqli('localhost', 'root', 'KisaragiEki4');
            $databases = [
                "Users",
                "Entries",
                "Words"
            ];
            $queries = [
                "CREATE DATABASE IF NOT EXISTS $database",
                "CREATE USER IF NOT EXISTS '$database'@'localhost' IDENTIFIED BY 'kISARAGIeKI4'",
                "GRANT SELECT, UPDATE, INSERT, DELETE, DROP, CREATE ON {$database}.* TO '{$database}'@'localhost'"
            ];
            foreach($databases as $database) {
                foreach($queries as $query) {
                    $mysql->query($query);
                }
            }
            $query = "USE $database";
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
            $query = "REVOKE CREATE, DROP ON Users.* FROM 'Users'@'localhost'";
            $mysql->query($query);
            $mysql->close();
        }
    }
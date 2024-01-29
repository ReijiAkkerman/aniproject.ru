<?php
    namespace project\control;

    trait Init {
        public function init(): void {
            $mysql = new \mysqli('localhost', 'root', 'KisaragiEki4');
            $users = ['User', 'Calendar', 'Todo', 'Scheduler'];
            foreach($users as $user) {
                $queries = [
                    "CREATE DATABASE $user",
                    "CREATE USER '$user'@'locahost' IDENTIFIED BY 'kISARAGIeKI4'",
                    "GRANT SELECT, INSERT, UPDATE, DELETE, CREATE ON $user.* TO '$user'@'localhost'",
                    "FLUSH PRIVILEGES"
                ];
                foreach($query as $key => $value) {
                    $mysql->query($value);
                }
            }
            $queries = [
                "USE User",
                "CREATE TABLE User(id SERIAL, login TEXT, password TEXT, registration_timestamp INT)"
            ];
            foreach($queries as $query) {
                $mysql->query($query);
            }
            $mysql->close();
        }
    }
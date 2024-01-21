<?php
    namespace project\control;

    require_once __DIR__ . '/abstract/Page.php';

    require_once __DIR__ . '/traits/Init.php';
    require_once __DIR__ . '/traits/ValidateUser.php';
    require_once __DIR__ . '/traits/ViewPage.php';

    class Reg extends Page {
        public $login;
        public $password;

        use Init;
        use ValidateUser;
        use ViewPage;

        public function __construct() {
            
        }

        public function registrate(): void {
            try {
                $timestamp = time();
                $mysql = new \mysqli('localhost', 'User', 'kISARAGIeKI4', 'User');
                $query = "INSERT INTO User(login, password, registration_timestamp) VALUES ('$login', '$password', $timestamp)";
                $mysql->query($query);
                $mysql->close();
                $users = ["Calendar", "Todo", "Scheduler"];
                foreach($users as $user) {
                    $mysql = new \mysqli('localhost', $user, 'kISARAGIeKI4', $user);
                    $query = [
                        "CREATE TABLE $user(
                            id SERIAL,
                            header TEXT,
                            content TEXT,
                            creation_timestamp INT,
                            start_timestamp INT,
                            end_timestamp INT,
                            whole_day BOOLEAN
                        )"
                    ];
                    $mysql->query($query);
                    $mysql->close();
                }
            }
            catch(Throwable) {
                header("Location: ../error/view");
            }
        }
    }
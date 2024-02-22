<?php
    namespace project\control\traits;

    trait Access {
        public function createAccessToken(): void {
            $this->accessToken = sha1('' . $this->login . time());
        }

        public function getAccessToken(string $server = 'localhost'): void {
            $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
            $query = "SELECT access_token FROM users WHERE ID={$this->userID}";
            $result = $mysql->query($query);
            $mysql->close();
            if($result->num_rows) {
                foreach($result as $row) {
                    $this->accessToken = $row['access_token'];
                }
            }
        }
    }
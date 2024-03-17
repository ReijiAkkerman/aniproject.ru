<?php
    namespace project\control\parent;

    use project\core\Router;

    abstract class Page {
        protected array $exclude;
        protected int $activityTime;
        protected string $userID;
        protected string $accessToken;

        protected string $server = '172.18.0.2';
        protected string $connect_from = '%';

        abstract public function view();

        protected function constructor(): void {
            $this->exclude = [
                'reg',
                'log'
            ];
            $this->activityTime = 3600 * 24 * 30;
            $this->userID = false;
            $this->accessToken = false;
            $this->getRoute();
        }

        private function getRoute(): void {
            $isAccessToken = $this->validateAccessToken($this->server);
            if($isAccessToken) {
                setcookie('ID', $this->userID, time() + $this->activityTime, '/');
                setcookie('token', $this->accessToken, time() + $this->activityTime, '/');
                if(in_array(Router::$folder, $this->exclude)) {
                    header("Location: ../calendar/view");
                    exit;
                }
            }
            else {
                setcookie('ID', 0, time() - 1, '/');
                setcookie('token', 0, time() - 1, '/');
                if(in_array(Router::$folder, $this->exclude)) {
                    ;
                }
                else {
                    header("Location: ../log/view");
                    exit;
                }
            }
        }

        private function validateAccessToken(string $server = 'localhost'): bool {
            if(isset($_COOKIE['ID']))
                $this->userID = $_COOKIE['ID'];
            if(isset($_COOKIE['token']))
                $this->accessToken = $_COOKIE['token'];
            if($this->userID && $this->accessToken) {
                $mysql = new \mysqli($server, 'Users', 'kISARAGIeKI4', 'Users');
                $query = "SELECT access_token FROM users WHERE ID={$this->userID}";
                $result = $mysql->query($query);
                $mysql->close();
                if($result->num_rows) {
                    foreach($result as $row) {
                        if($this->accessToken === $row['access_token'])
                            return true;
                        else 
                            return false;
                    }
                }
                else 
                    return false;
            }
            else 
                return false;
        }
    }
<?php
    class A {
        public function hello() {
            $mysql = new \mysqli('172.18.0.2', 'root', 'KisaragiEki4');
            $query = "SHOW TABLES IN Users";
            $data = $mysql->query($query);
            foreach($data as $row) {
                if($row['Tables_in_Users'] === 'users')
                    echo $row['Tables_in_Users'] . "\n";
            }
            $mysql->close();
        }
    }

    $obj = new A;
    $obj->hello();
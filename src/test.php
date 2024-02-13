<?php
    class hello {
        public function hello() {
            $mysql = new mysqli('localhost', 'root', 'KisaragiEki4', 'test');
            $query = "SELECT EXISTS( SELECT ID,name FROM hello WHERE surname IN('kasugano', 'tachibana')) AS found";
            $result = $mysql->query($query);
            echo $result->num_rows;
        }
    }

    $obj = new hello;
    $obj->hello();
<?php
    class A {
        public $a;
        public $b;

        public function __construct() {
            $this->a = 'hello';
        }

        public function hello() {
            if($this->b)
                echo 'good';
            else 
                echo 'BAD';
        }
    }

    $obj = new A();
    $obj->hello();
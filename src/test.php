<?php
    abstract class A {
        public $public;
        protected $protected;

        public function __construct() {
            $this->public = 'public';
            $this->protected = 'protected';
        }

        
    }

    class B extends A {
        public function printPublic(): void {
            echo $this->public . "\n";
        }

        public function printProtected(): void {
            echo $this->protected . "\n";
        }
    }

    $obj = new B();
    $obj->printPublic();
    $obj->printProtected();
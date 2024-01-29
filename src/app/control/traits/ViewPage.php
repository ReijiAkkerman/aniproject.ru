<?php
    namespace project\control;

    trait ViewPage {
        public function view(): void {
            $classname = __CLASS__;
            $class_array = explode('\\', $classname);
            $class = end($class_array);
            require_once __DIR__ . '/../../view/pages/' . lcfirst($class) . '.php';
        }
    }
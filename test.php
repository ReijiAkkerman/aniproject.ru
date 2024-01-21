<?php
    class A {
        public $str = 'string';

        public function hello() {
            $test_string = $this->str . " " . $this->str;

            $str1;
            $str2;
            $str3;

            $this->test1($test_string);
            $this->test2($test_string);
            $this->test3($test_string);

            echo $str1 . '_' . $str2 . '_' . $str3 . "\n";
        }

        private function test1($str) {
            $str1 = $str[0];
        }

        private function test2($str) {
            $str2 = $str[2];
        }

        private function test3($str) {
            $str3 = $str[4];
        }
    }

    $obj = new A;
    $obj->hello();
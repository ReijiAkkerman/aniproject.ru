<?php
    trait A {
        public function hello() {
            echo 'hello ';
        }
    }

    trait B {
        public function hello() {
            echo 'world';
        }
    }

    trait D {
        public function hello() {
            echo '!' . "\n";
        }
    }

    class C {
        use A {
            A::hello insteadOf B, D;
            A::hello as hi;
        }
        use B {
            B::hello as world;
        }
        use D {
            D::hello as sign;
        }
    }

    $obj = new C;
    $obj->hi();
    $obj->world();
    $obj->sign();
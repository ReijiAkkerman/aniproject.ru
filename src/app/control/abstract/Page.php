<?php
    namespace project\control;

    abstract class Page {
        protected array $exclude;

        abstract public function view();

        private function constructor(): void {
            $this->exclude = [
                'reg',
                'log'
            ];
        }

        protected function validateAccess(): bool {
            $isElement = in_array(Router::$fdolder, $this->exclude);
            if($isElement) {
                
            }
        }
    }
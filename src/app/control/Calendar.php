<?php
    namespace project\control;

    use project\control\parent\Page;
    use project\control\traits\ViewPage;

    class Calendar extends Page {
        public function __construct() {
            $this->constructor();
        }

        use ViewPage;

        public function entry(string $method): void {
            
        }
    }
<?php
    namespace project\control;

    use project\control\parent\Page;
    use project\control\traits\ViewPage;
    use project\model\Entry;

    class Calendar extends Page {
        public function __construct() {
            $this->constructor();
        }

        use ViewPage;

        public function entry(array $methods): void {
            $method = $methods[0];
            $entry = new Entry();
            $entry->$method();
        }
    }
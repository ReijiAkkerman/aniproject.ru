<?php
    namespace project\control;

    use project\control\parent\Page;

    use project\control\traits\ViewPage;

    use project\model\Entry;
    
    use project\view\Calendar as view_Calendar;

    class Calendar extends Page {
        public function __construct() {
            $this->constructor();
        }

        public function view(): void {
            $calendar = new view_Calendar();
            include_once __DIR__ . "/../view/pages/calendar.php";
        }

        public function entry(array $methods): void {
            $method = $methods[0];
            $entry = new Entry();
            $entry->$method();
        }
    }
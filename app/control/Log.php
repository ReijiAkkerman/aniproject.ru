<?php
    namespace project\control;

    require_once __DIR__ . '/abstract/Page.php';
    require_once __DIR__ . '/traits/ViewPage.php';

    class Log extends Page {
        use ViewPage;

        public function login(): void {
            $mysql = new \mysqli('localhost', );
        }
    }
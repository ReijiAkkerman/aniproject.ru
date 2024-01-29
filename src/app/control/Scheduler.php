<?php
    namespace project\control;

    require_once __DIR__ . "/abstract/Page.php";
    require_once __DIR__ . "/traits/ViewPage.php";

    class Scheduler extends Page {
        use ViewPage;
    }
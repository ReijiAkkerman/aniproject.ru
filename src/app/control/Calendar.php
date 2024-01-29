<?php
    namespace project\control;

    require_once __DIR__ . "/abstract/Page.php";
    require_once __DIR__ . "/traits/ViewPage.php";

    class Calendar extends Page {
        use ViewPage;
    }
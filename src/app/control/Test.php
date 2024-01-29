<?php
    namespace project\control;

    require_once __DIR__ . "/abstract/Pege.php";
    require_once __DIR__ . "/traits/ViewPage.php";

    class Test extends Page {
        use ViewPage;
    }
<?php
    namespace project\control;

    require_once __DIR__ . "/abstract/Page.php";
    require_once __DIR__ . "/traits/ViewPage.php";

    class Error extends Page {
        use ViewPage;
    }
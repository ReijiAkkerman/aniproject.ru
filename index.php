<?php
    namespace project;

    use project\core\Router;

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/app/core/Router.php';

    $obj = new Router();
    $obj->action();

    // require_once "app/view/pages/reg.php";
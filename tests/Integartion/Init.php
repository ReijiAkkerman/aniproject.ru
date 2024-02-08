<?php
    namespace tests\Integration;

    require __DIR__ . "/../../vendor/autoload.php";

    use project\control\Reg;

    $obj = new Reg;
    $obj->init('mysql');
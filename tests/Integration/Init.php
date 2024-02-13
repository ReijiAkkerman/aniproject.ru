<?php
    namespace tests\Integration;

    require __DIR__ . "/../../vendor/autoload.php";

    use project\control\Reg;

    $_POST['email'] = 'reijiakkerman@gmail.com';
    $_POST['login'] = 'ReijiAkkerman';
    $_POST['name'] = 'Reiji';
    $_POST['password1'] = 'KisaragiEki4';
    $_POST['password2'] = 'KisaragiEki4';

    $obj = new Reg();
    $obj->init('mysql', '%');
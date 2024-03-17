<?php
    $_POST['without_time'] = 'on';
    $without_time = isset($_POST['without_time']) && $_POST['without_time'];
    // echo var_dump($without_time);
    if($_POST['without_time'])
        echo 'hello';
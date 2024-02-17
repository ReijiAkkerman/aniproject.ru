<?php
    $regex = '#^[A-Za-z0-9]{1,50}$#';
    $value = 'Reiji-';
    $checked = preg_match($regex, $value);
    if($checked)
        echo 'good';
    else 
        echo 'BAD';
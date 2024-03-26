<?php
    $full_interval = new DateInterval('P1Y');
    $start = new DateTimeImmutable();
    $end = $start->add($full_interval);
    $day_interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $day_interval, $end);
    foreach($period as $day) {
        echo $day->format('d-m-Y') . "\n";
    }
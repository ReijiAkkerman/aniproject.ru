<?php
    namespace project\view\traits;

    trait RepeatUpTo {
        public $repeatUpTo_period;
        public $repeatUpTo_startActive;

        public function getDates(): \DateTimeImmutable {
            $start;
            $end;
            $dayInterval;
            $calendarInterval;
            
            $getStartDate = function () use (&$start, &$dayInterval) {
                $dayInterval = new \DateInterval('P1D');
                $deltaDays = $this->now->format('w');
                $deltaDaysInterval = new \DateInterval("P{$deltaDays}D");
                $start = $this->now->sub($deltaDaysInterval);
            };

            $getEndDate = function () use (&$end, &$calendarInterval, &$start) {
                $calendarInterval = new \DateInterval('P1Y');
                $end = $start->add($calendarInterval);
                $deltaDays = $end->format('w');
                $deltaDays = 7 - $deltaDays;
                $deltaDaysInterval = new \DateInterval("P{$deltaDays}D");
                $end = \DateTime::createFromImmutable($end);
                $end->add($deltaDaysInterval);
            };

            $getStartDate();
            $getEndDate();

            $this->repeatUpTo_period = new \DatePeriod($start, $dayInterval, $end);
            return $start;
        }
    }
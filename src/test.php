<?php
    class Calendar {
        public \DateTimeImmutable $start;
        public \DateTimeImmutable $now;
        public \DateTimeImmutable $end;
        public \DateInterval $calendarInterval;
        public \DateInterval $dayInterval;
        public \DatePeriod $period;

        public function __construct() {
            $this->now = new \DateTimeImmutable();
            $this->calendarInterval = new \DateInterval('P1D');
            $this->dayInterval = new \DateInterval('P1D');
        }
        
        // public function getDefaultDates(): void {
        //     $this->getStart();
        //     $this->getEnd();
        //     $this->period = new \DatePeriod($this->start, $this->dayInterval, $this->end);
        // }

        public function compareObjects(): void {
            $this->start = $this->now->sub($this->calendarInterval);
            $this->end = $this->now->add($this->calendarInterval);
            $this->period = new \DatePeriod($this->start, $this->dayInterval, $this->end, \DatePeriod::INCLUDE_END_DATE);
        }

        // private function getStart(): void {
        //     $this->start = \DateTime::createFromImmutable($this->now);
        //     $this->start->sub($this->calendarInterval);
        //     $deltaDays = $this->start->format('w');
        //     $deltaDaysInterval = new \DateInterval("P{$deltaDays}D");
        //     $this->start->sub($deltaDaysInterval);
        // }

        // private function getEnd(): void {
        //     $this->end = \DateTime::createFromImmutable($this->now);
        //     $this->end->add($this->calendarInterval);
        //     $deltaDays = $this->end->format('w');
        //     $deltaDays = 7 - $deltaDays;
        //     $deltaDaysInterval = new \DateInterval("P{$deltaDays}D");
        //     $this->end->add($deltaDaysInterval);
        // }
    }

    $obj = new Calendar();
    $obj->compareObjects();
    foreach($obj->period as $day) {
        echo $day->format('d.m.o l') . "\n";
        echo var_dump($obj->now == $day);
    }
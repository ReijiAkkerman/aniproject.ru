<?php
    namespace project\view;

    class Calendar {
        public \DateTime $start;
        public \DateTimeImmutable $now;
        public \DateTime $end;
        public \DateInterval $calendarInterval;
        public \DateInterval $dayInterval;
        public \DatePeriod $period;

        public function __construct() {
            $this->now = new \DateTimeImmutable();
            $this->calendarInterval = new \DateInterval('P3M');
            $this->dayInterval = new \DateInterval('P1D');
        }
        
        public function getDefaultDates(): void {
            $this->getStart();
            $this->getEnd();
            $this->period = new \DatePeriod($this->start, $this->dayInterval, $this->end);
        }

        private function getStart(): void {
            $this->start = \DateTime::createFromImmutable($this->now);
            $this->start->sub($this->calendarInterval);
            $deltaDays = $this->start->format('w');
            $deltaDaysInterval = new \DateInterval("P{$deltaDays}D");
            $this->start->sub($deltaDaysInterval);
        }

        private function getEnd(): void {
            $this->end = \DateTime::createFromImmutable($this->now);
            $this->end->add($this->calendarInterval);
            $deltaDays = $this->end->format('w');
            $deltaDays = 7 - $deltaDays;
            $deltaDaysInterval = new \DateInterval("P{$deltaDays}D");
            $this->end->add($deltaDaysInterval);
        }
    }
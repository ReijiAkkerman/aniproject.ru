<?php
    namespace project\view;

    class Calendar {
        public \DateTimeImmutable $start;
        public \DateTimeImmutable $now;
        public \DateTimeImmutable $end;
        public \DateInterval $interval;

        public function __construct() {
            $this->now = new \DateTimeImmutable();
            $this->interval = new \DateInterval('P3M');
        }
        
        public function getDates(): Calendar {
            return $this;
        }
        
        public function getDefaultDatesRange(): void {
            $this->start = $this->now->sub($interval);
            $this->end = $this->now->add($interval);
        }
    }
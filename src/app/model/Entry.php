<?php
    namespace project\model;

    use project\model\abstract\iEntry;

    class Entry implements iEntry {
        public string $title;
        public string $description;
        public int $start;
        public int $created;
        public int $end;
        public bool $without_time;
        public bool $to_end_day;
        public string $repetition;
        public string $cathegory;
        public string $users;
        public string $materials;
        public string $parent;
        public string $direct_descendants;



        public function getEntry(): Entry|false {

        }

        public function getEntries(): array|false {

        }

        public function saveEntries(): bool {

        }





        
    }
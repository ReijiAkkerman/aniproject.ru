<?php
    namespace project\model\abstract;

    use project\model\Entry;

    interface iEntry {
        public function getEntries(): void;
        public function saveEntries(): void;
        public function deleteEntries(): bool;
        public function updateEntries(): bool;
    }
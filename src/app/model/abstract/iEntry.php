<?php
    namespace project\model\abstract;

    use project\model\Entry;

    interface iEntry {
        public function getEntries(): array|bool;
        public function saveEntries(): bool;
        public function deleteEntries(): bool;
        public function updateEntries(): bool;
    }
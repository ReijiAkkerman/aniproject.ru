<?php
    namespace project\model\abstract;

    use project\model\Entry;

    interface iEntry {
        public function getEntry(): Entry|false;
        public function getEntries(): array|false;
        public function saveEntries(): bool;
    }
<?php
    namespace project\model\abstract;

    interface iData {
        public function getTitle(): bool;
        public function getDescription(): bool;
        public function getValues(): bool;
    }
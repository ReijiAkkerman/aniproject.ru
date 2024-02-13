<?php
    namespace project\control\enum;

    enum Regex: string {
        case email = '#[a-z][a-z0-9]{3,30}@[a-z]{1,20}\.[a-z]{2,5}#';
        case login = '#[A-Za-z0-9]{6,50}#';
        case name = '#[A-Za-z0-9]{1,50}#';
        case password = '#[A-Za-z0-9_.]{10,100}#';
    }
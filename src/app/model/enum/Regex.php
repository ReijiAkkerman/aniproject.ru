<?php
    namespace project\model\enum;

    enum Regex: string {
        case title = "#^[^!@\#$%^&*()+=\[\]{}\\\\|'\";:/?><`~]+$#";
        case description = "#^[^\#^&{}\[\];'\\\\|<>~`+=$]+$#";
        case year = "#^[1-9][0-9]{0,3}$#";
        case month = "#^(1[012]|[1-9])$#";
        case day = "#^([0-9]|[12][0-9]|3[01])$#";
        case hour = "#^(1?[0-9]|2[0-3])$#";
        case minute = "#^[1-5]?[0-9]$#";
        case necessity = "#^on$#";
        case weekday = "#^(monday|tuesday|wednesday|thursday|friday|saturday|sunday)$#";
        case cath = "#^[a-zA-Z0-9_\- ]{1,200}$#";
        case task_nesting = "#^[a-zA-Z0-9_\- >]+$#";
        case users = "#^[a-zA-Z0-9_\- ,]+$#";
    }
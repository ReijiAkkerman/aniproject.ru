<?php
    namespace project\model\traits;

    use project\model\enum\Regex;

    trait Task {
        public function getValues(): bool {
            $newTask = $this->isNewTask();
            $recentTasks = $this->areRecentTasks();
            if($newTask !== false && $recentTasks !== false) {
                if($newTask && $recentTasks) {
                    $this->error_message .= urlencode("Ошибка!!! Одновременно не может быть указаны новая и существующая задача!!!");
                    return false;
                }
                else if($newTask) 
                    return true;
                else if($recentTasks) 
                    return true;
                else {
                    $this->task_nesting = 'none';
                    return true;
                }
            }
            else 
                return false;
        }

        public function isNewTask(): int|false {
            if($_POST['new_task']) {
                $regex = Regex::task_nesting;
                $valueMatches = preg_match($regex->value, $_POST['new_task']);
                if($valueMatches) {
                    $this->task_nesting = $_POST['new_task'];
                    return 1;
                }
                else {
                    $this->error_message .= urlencode("Внимание! Поле 'Новая задача' содержит недопустимые символы или длину!");
                    return false;
                }
            }
            else 
                return 0;
        }

        public function areRecentTasks(): int|false {
            $counter = 0;
            for($i = 0; $i < 5; $i++) {
                if(isset($_POST['task' . $i]) && $_POST['task' . $i]) {
                    $regex = Regex::task_nesting;
                    $valueMatches = preg_match($regex->value, $_POST['task' . $i]);
                    if($valueMatches) {
                        $counter++;
                        if($counter > 1) {
                            $this->error_message .= urlencode("Внимание! Указать можно только одну из задач!");
                            return false;
                        }
                        $this->task_nesting = $_POST['task' . $i];
                    }
                    else {
                        $this->error_message .= urlencode("Ошибка!!! Указанная недавняя задача сожержит недопустимые символы или длину!!!");
                        return false;
                    }
                }
            }
            return $counter;
        }
    }
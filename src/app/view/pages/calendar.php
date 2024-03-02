<?php 
    use project\view\Calendar;
?>
<!DOCTYPE html>
<html>
    <head>
    <?php include_once __DIR__ . "/components/common/head.php" ?>
    </head>
    <body class="calendar">
    <?php include_once __DIR__ . "/components/common/header.php" ?>
        <main class="Calendar">
        <?php
            $calendar = new Calendar();
            $calendar->getDefaultDates();
            $month = $calendar->start->format('n');
            $year = $calendar->start->format('o');
            foreach($calendar->period as $day) {
        ?>
            <div class="Day <?php if($day->format('w') == 0) echo "start" ?>" id="<?php if($calendar->now == $day) echo "now"; ?>">
                <div class="Header">
                    <button>
                    <?php
                        echo $day->format('d');
                        if($month != $day->format('n'))
                            echo "/" . $day->format('n');
                        else 
                            echo "<span>/" . $day->format('n') . "</span>";
                        if($year != $day->format('o'))
                            echo '/' . $day->format('o');
                    ?>
                    </button>
                </div>
                <div class="Body">

                </div>
            </div>
        <?php
                $month = $day->format('n');
                $year = $day->format('o');
            } 
        ?>
        </main>
        <section class="NewEntry">
            <form action="#" method="POST">
                <div class="Main">
                    <div>
                        <p class="bold">Наименование записи</p>
                        <input type="text" name="name">
                    </div>
                    <div>
                        <p class="bold">Описание</p>
                        <textarea name="description"></textarea>
                    </div>
                    <div class="Date">
                        <div class="start">
                            <button class="bold">Начало</button>
                            <div>
                                <div>
                                    <p>Год</p>
                                    <input type="text" maxlength=4>
                                </div>
                                <div>
                                    <p>Месяц</p>
                                    <input type="text" maxlength=2>
                                </div>
                                <div>
                                    <p>День</p>
                                    <input type="text" maxlength=2>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <p>Час</p>
                                    <input type="text" maxlength=2>
                                </div>
                                <div>
                                    <p>Минута</p>
                                    <input type="text" maxlength=2>
                                </div>
                                <input type="hidden">
                            </div>
                        </div>
                        <div class="end">
                            <button class="bold">Конец</button>
                            <div>
                                <div>
                                    <p>Год</p>
                                    <input type="text" maxlength=4>
                                </div>
                                <div>
                                    <p>Месяц</p>
                                    <input type="text" maxlength=2>
                                </div>
                                <div>
                                    <p>День</p>
                                    <input type="text" maxlength=2>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <p>Час</p>
                                    <input type="text" maxlength=2>
                                </div>
                                <div>
                                    <p>Минута</p>
                                    <input type="text" maxlength=2>
                                </div>
                            </div>
                            <input type="hidden">
                        </div>
                    </div>
                    <div class="Repeat">
                        <p class="bold">Повторение</p>
                        <div>
                            <div>
                                <div>
                                    <input type="checkbox" name="day" id="day">
                                    <label for="day">День</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="month" id="month">
                                    <label for="month">Месяц</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="week" id="week">
                                    <label for="week">Неделя</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="year" id="year">
                                    <label for="year">Год</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="interval" id="interval">
                                    <label for="interval">Свой интервал</label>
                                </div>
                                <div class="set_time">
                                    <input type="checkbox" name="set_time" id="set_time">
                                    <label for="set_time">Указать время</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Supplement">
                        <div class="Week">
                            <div>
                                <div>
                                    <input type="checkbox" name="monday" id="monday">
                                    <label for="monday">Понедельник</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="tuesday" id="tuesday">
                                    <label for="tuesday">Вторник</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="wednesday" id="wednesday">
                                    <label for="wednesday">Среда</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="thursday" id="thursday">
                                    <label for="thursday">Четверг</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="friday" id="friday">
                                    <label for="friday">Пятница</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="saturday" id="saturday">
                                    <label for="saturday">Суббота</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="sunday" id="sunday">
                                    <label for="sunday">Воскресенье</label>
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div class="Interval">
                            <div>
                                <p>Год</p>
                                <input type="text" maxlength=4>
                            </div>
                            <div>
                                <p>Месяц</p>
                                <input type="text" maxlength=2>
                            </div>
                            <div>
                                <p>День</p>
                                <input type="text" maxlength=2>
                            </div>
                            <div class="SetTime">
                                <p>Час</p>
                                <input type="text" maxlength=2>
                            </div>
                            <div class="SetTime">
                                <p>Минута</p>
                                <input type="text" maxlength=2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Adds">
                    <div>
                        <p class="bold">Категории</p>
                        <div class="list">
                            <p>Категория</p>
                            <button>
                                <svg viewBox="0 0 1024 1024">
                                <path d="M831.872 340.864 512 652.672 192.128 340.864a30.592 30.592 0 0 0-42.752 0 29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728 30.592 30.592 0 0 0-42.752 0z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="text" name="new_user" placeholder="Новая категория">
                        <div class="recent">
                            <div>
                                <input type="checkbox" name="cath1<?= "" ?>" value="" id="cath1">
                                <label for="cath1">Cathegory1</label>
                            </div>
                            <div>
                                <input type="checkbox" name="cath2<?= "" ?>" value="" id="cath2">
                                <label for="cath2">Cathegory2</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="bold">Пользователи</p>
                        <div class="list">
                            <p>Пользователь</p>
                            <button>
                                <svg viewBox="0 0 1024 1024">
                                <path d="M831.872 340.864 512 652.672 192.128 340.864a30.592 30.592 0 0 0-42.752 0 29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728 30.592 30.592 0 0 0-42.752 0z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="text" name="new_user" placeholder="Новый пользователь">
                        <div class="recent">
                            <div>
                                <input type="checkbox" name="user1<?= "" ?>" value="" id="user1">
                                <label for="user1">User1</label>
                            </div>
                            <div>
                                <input type="checkbox" name="user2<?= "" ?>" value="" id="user2">
                                <label for="user2">User2</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button>Сохранить</button>
                    </div>
                </div>
            </form>
        </section>
        <section class="RepeatUpTo">
            <p>Повторять по</p>
            <p>Выбрать дату</p>
            <div class="Date">
                <div>
                    <p>Год</p>
                    <input type="text" name="year">
                </div>
                <div>
                    <p>Месяц</p>
                    <input type="text" name="month">
                </div>
                <div>
                    <p>День</p>
                    <input type="text" name="day">
                </div>
            </div>
            <div class="Calendar">
            <?php
                for($i = 0; $i < 70; $i++) {
            ?>
                <button>
                    <div>
                        <p>1/1/24</p>
                    </div>
                </button>
            <?php } ?>
            </div>
        </section>
        <script type="module" src="/src/js/calendar.js"></script>
    </body>
</html>
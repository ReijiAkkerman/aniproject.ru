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
                        <input type="text" name="title">
                    </div>
                    <div>
                        <p class="bold">Описание</p>
                        <textarea name="description"></textarea>
                    </div>
                    <div class="Date">
                        <div class="start">
                            <button class="bold" id="DateTime_start">Начало</button>
                            <div>
                                <div>
                                    <p>Год</p>
                                    <input type="text" maxlength=4 name="start_year">
                                </div>
                                <div>
                                    <p>Месяц</p>
                                    <input type="text" maxlength=2 name="start_month">
                                </div>
                                <div>
                                    <p>День</p>
                                    <input type="text" maxlength=2 name="start_day">
                                </div>
                            </div>
                            <div>
                                <div>
                                    <p>Час</p>
                                    <input type="text" maxlength=2 name="start_hour">
                                </div>
                                <div>
                                    <p>Минута</p>
                                    <input type="text" maxlength=2 name="start_minute">
                                </div>
                                <input type="hidden" name="without_time">
                            </div>
                        </div>
                        <div class="end">
                            <button class="bold" id="DateTime_end">Конец</button>
                            <div>
                                <div>
                                    <p>Год</p>
                                    <input type="text" maxlength=4 name="end_year">
                                </div>
                                <div>
                                    <p>Месяц</p>
                                    <input type="text" maxlength=2 name="end_month">
                                </div>
                                <div>
                                    <p>День</p>
                                    <input type="text" maxlength=2 name="end_day">
                                </div>
                            </div>
                            <div>
                                <div>
                                    <p>Час</p>
                                    <input type="text" maxlength=2 name="end_hour">
                                </div>
                                <div>
                                    <p>Минута</p>
                                    <input type="text" maxlength=2 name="end_minute">
                                </div>
                            </div>
                            <input type="hidden" name="to_end_day">
                        </div>
                    </div>
                    <div class="Repeat">
                        <p class="bold">Повторение</p>
                        <div>
                            <div>
                                <div>
                                    <input type="checkbox" name="every_day" id="every_day">
                                    <label for="every_day">День</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="every_month" id="every_month">
                                    <label for="every_month">Месяц</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="every_week" id="every_week">
                                    <label for="every_week">Неделя</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="every_year" id="every_year">
                                    <label for="every_year">Год</label>
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
                                    <input type="checkbox" name="monday" id="monday" value="monday">
                                    <label for="monday">Понедельник</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="tuesday" id="tuesday" value="tuesday">
                                    <label for="tuesday">Вторник</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="wednesday" id="wednesday" value="wednesday">
                                    <label for="wednesday">Среда</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="thursday" id="thursday" value="thursday">
                                    <label for="thursday">Четверг</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="friday" id="friday" value="friday">
                                    <label for="friday">Пятница</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="saturday" id="saturday" value="saturday">
                                    <label for="saturday">Суббота</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="sunday" id="sunday" value="sunday">
                                    <label for="sunday">Воскресенье</label>
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div class="Interval">
                            <div>
                                <p>Год</p>
                                <input type="text" maxlength=4 name="interval_year">
                            </div>
                            <div>
                                <p>Месяц</p>
                                <input type="text" maxlength=2 name="interval_month">
                            </div>
                            <div>
                                <p>День</p>
                                <input type="text" maxlength=2 name="interval_day">
                            </div>
                            <div class="SetTime">
                                <p>Час</p>
                                <input type="text" maxlength=2 name="interval_hour">
                            </div>
                            <div class="SetTime">
                                <p>Минута</p>
                                <input type="text" maxlength=2 name="interval_minute">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Adds">
                    <div>
                        <div>
                            <p class="bold">Категории</p>
                            <div class="switchTo">
                                <button>
                                    <svg viewBox="0 0 512.006 512.006">
                                        <path d="M388.419,475.59L168.834,256.005L388.418,36.421c8.341-8.341,8.341-21.824,0-30.165s-21.824-8.341-30.165,0
                                            L123.586,240.923c-8.341,8.341-8.341,21.824,0,30.165l234.667,234.667c4.16,4.16,9.621,6.251,15.083,6.251
                                            c5.461,0,10.923-2.091,15.083-6.251C396.76,497.414,396.76,483.931,388.419,475.59z"/>
                                    </svg>
                                </button>
                                <button>
                                    <svg viewBox="0 0 512.005 512.005">
                                        <path d="M388.418,240.923L153.751,6.256c-8.341-8.341-21.824-8.341-30.165,0s-8.341,21.824,0,30.165L343.17,256.005
                                            L123.586,475.589c-8.341,8.341-8.341,21.824,0,30.165c4.16,4.16,9.621,6.251,15.083,6.251c5.461,0,10.923-2.091,15.083-6.251
                                            l234.667-234.667C396.759,262.747,396.759,249.264,388.418,240.923z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="changeable cathegories">
                            <div class="list">
                                <p>Категория</p>
                                <button>
                                    <svg viewBox="0 0 1024 1024">
                                    <path d="M831.872 340.864 512 652.672 192.128 340.864a30.592 30.592 0 0 0-42.752 0 29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728 30.592 30.592 0 0 0-42.752 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input type="text" name="new_cath" placeholder="Новая категория">
                            <div class="recent">
                                <div>
                                    <input type="checkbox" name="cath<?= "" ?>" value="<?= "" ?>" id="cath<?= "" ?>">
                                    <label for="cath<?= "" ?>">Cathegory1</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="cath<?= "" ?>" value="<?= "" ?>" id="cath<?= "" ?>">
                                    <label for="cath<?= "" ?>">Cathegory2</label>
                                </div>
                            </div>
                        </div>
                        <div class="changeable tasks">
                            <div class="list">
                                <p>Задача</p>
                                <button>
                                    <svg viewBox="0 0 1024 1024">
                                    <path d="M831.872 340.864 512 652.672 192.128 340.864a30.592 30.592 0 0 0-42.752 0 29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728 30.592 30.592 0 0 0-42.752 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input type="text" name="new_cath" placeholder="Новая задача">
                            <div class="recent">
                                <div>
                                    <input type="checkbox" name="cath<?= "" ?>" value="<?= "" ?>" id="task<?= "" ?>">
                                    <label for="task<?= "" ?>">Task1</label>
                                </div>
                                .Header .Links .View > button <div>
                                    <input type="checkbox" name="cath<?= "" ?>" value="<?= "" ?>" id="task<?= "" ?>">
                                    <label for="task<?= "" ?>">Task2</label>
                                </div>
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
                                <input type="checkbox" name="user<?= "" ?>" value="<?= "" ?>" id="user<?= "" ?>">
                                <label for="user<?= "" ?>">User1</label>
                            </div>
                            <div>
                                <input type="checkbox" name="user<?= "" ?>" value="<?= "" ?>" id="user<?= "" ?>">
                                <label for="user<?= "" ?>">User2</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button id="save_button">Сохранить</button>
                    </div>
                </div>
            </form>
            <div class="RepeatUpTo">
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
            </div>
        </section>
        <script type="module" src="/src/js/calendar.js"></script>
    </body>
</html>
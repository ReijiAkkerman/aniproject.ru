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
            <div class="Day <?php if($day->format('w') == 0) echo "start" ?>">
                <div class="Header">
                    <button>
                    <?php
                        echo $day->format('d');
                        if($month != $day->format('n'))
                            echo '/' . $day->format('n');
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
                            <p class="bold">Начало</p>
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
                        </div>
                        <div class="end">
                            <p class="bold">Конец</p>
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
                                    <input type="checkbox" name="own_time" id="own_time">
                                    <label for="own_time">Указать время</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="interval" id="interval">
                                    <label for="interval">Свой интервал</label>
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
                                <div>
                                    <input type="checkbox" name="sunday" id="sunday">
                                    <label for="sunday">Воскресенье</label>
                                </div>
                            </div>
                        </div>
                        <div class="SetTime">
                            <div>
                                <p>Час</p>
                                <input type="text" maxlength=2>
                            </div>
                            <div>
                                <p>Минута</p>
                                <input type="text" maxlength=2>
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
                            <div>
                                <p>Час</p>
                                <input type="text" maxlength=2>
                            </div>
                            <div>
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
                        <div class="recent">
                            <div>
                                <input type="checkbox" name="user<?= "" ?>" value="" id="cath">
                                <label for="cath">Cathegory</label>
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
                        <div class="recent">
                            <div>
                                <input type="checkbox" name="user<?= "" ?>" value="" id="user">
                                <label for="user">User</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </body>
</html>
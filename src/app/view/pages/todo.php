<!DOCTYPE html>
<html>
    <head>
    <?php include_once __DIR__ . "/components/common/head.php" ?>
    </head>
    <body class="todo">
    <?php include_once __DIR__ . "/components/common/header.php" ?>
        <section class="Subsection">
            <div class="Type">
                <button>
                    <pre>Категория 1</pre>
                </button>
                <div class="Subtype">
                    <button>
                        <pre>Задача 1</pre>
                    </button>
                    <div class="Subtype">
                        <button>
                            <pre>Подзадача 1</pre>
                        </button>
                        <button>
                            <pre>Подзадача 2</pre>
                        </button>
                    </div>
                    <button>
                        <pre>Задача 2</pre>
                    </button>
                    <button>
                        <pre>Задача 3</pre>
                    </button>
                </div>
                <button>
                    <pre>Категория 2</pre>
                </button>
                <button>
                    <pre>Категория 3</pre>
                </button>
            </div>
        </section>
        <main class="Info">
            <div class="Sorting">
                <div class="Cathegory">
                    <p>Категория:</p>
                    <div class="cases">
                        <div>
                            <input type="checkbox" id="begin">
                            <label for="begin">Сначала</label>
                        </div>
                        <div>
                            <input type="checkbox" id="only_titles">
                            <label for="only_titles">Только заголовки</label>
                        </div>
                        <div class="list">
                            <p>По алфавиту</p>
                            <button>
                                <svg viewBox="0 0 1024 1024">
                                <path d="M831.872 340.864 512 652.672 192.128 340.864a30.592 30.592 0 0 0-42.752 0 29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728 30.592 30.592 0 0 0-42.752 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php for($i = 0; $i < 8; $i++) { ?>
            <div class="Entry">
                <div>
                    <input type="text" name="name" value="Подзадача 2">
                </div>
                <div>
                    <div>
                        <div>
                            <textarea name="description"></textarea>
                        </div>
                        <div>
                            <div class="materials">
                                <a href="#">https://aniproject.ru/calendar/view</a>
                            </div>
                            <div class="child_tasks">
                                <ul>
                                    <li>Подзадача подзадачи 1</li>
                                    <li>Подзадача подзадачи 2</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <input type="text" name="cathegory" value="Категория 1">
                        </div>
                        <div>
                            <input type="text" name="time_end" value="14-8-2024 19:28:33">
                        </div>
                        <div>
                            <p class="left_time">2:04:00:00</p>
                        </div>
                        <div>
                            <p class="users">Пользователь 1<br>Пользователь 2</p>
                        </div>
                        <div>
                            <input type="text" name="parent_task" value="Задача 1">
                        </div>
                        <div>
                            <input type="text" name="time_start" value="12-8-2024 15:28:33">
                        </div>
                        <div>
                            <p class="time_creation">12-8-2024 15:28:33</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </main>
        <section class="Section">
            <div class="Cathegories">
                <button id="Cathegory">
                    <svg viewBox="0 0 24 24">
                    <path d="M9.5 2h-6A1.502 1.502 0 0 0 2 3.5v6A1.502 1.502 0 0 0 3.5 11h6A1.502 1.502 0 0 0 11 9.5v-6A1.502 1.502 0 0 0 9.5 2zm.5 7.5a.501.501 0 0 1-.5.5h-6a.501.501 0 0 1-.5-.5v-6a.501.501 0 0 1 .5-.5h6a.501.501 0 0 1 .5.5zM20.5 2h-6A1.502 1.502 0 0 0 13 3.5v6a1.502 1.502 0 0 0 1.5 1.5h6A1.502 1.502 0 0 0 22 9.5v-6A1.502 1.502 0 0 0 20.5 2zm.5 7.5a.501.501 0 0 1-.5.5h-6a.501.501 0 0 1-.5-.5v-6a.501.501 0 0 1 .5-.5h6a.501.501 0 0 1 .5.5zM9.5 13h-6A1.502 1.502 0 0 0 2 14.5v6A1.502 1.502 0 0 0 3.5 22h6a1.502 1.502 0 0 0 1.5-1.5v-6A1.502 1.502 0 0 0 9.5 13zm.5 7.5a.501.501 0 0 1-.5.5h-6a.501.501 0 0 1-.5-.5v-6a.501.501 0 0 1 .5-.5h6a.501.501 0 0 1 .5.5zM20.5 13h-6a1.502 1.502 0 0 0-1.5 1.5v6a1.502 1.502 0 0 0 1.5 1.5h6a1.502 1.502 0 0 0 1.5-1.5v-6a1.502 1.502 0 0 0-1.5-1.5zm.5 7.5a.501.501 0 0 1-.5.5h-6a.501.501 0 0 1-.5-.5v-6a.501.501 0 0 1 .5-.5h6a.501.501 0 0 1 .5.5z"/>
                    <path fill="none" d="M0 0h24v24H0z"/>
                    </svg>
                </button>
                <button id="Users">
                    <svg viewBox="0 0 459.864 459.864">
                    <path d="M395.988,193.978c-6.215,8.338-13.329,15.721-21.13,21.941c33.044,21.079,55.005,58.06,55.005,100.077
                        c0,13.638-20.011,23.042-31.938,27.434c-9.301,3.425-20.237,6.229-32.19,8.347c0.387,5.05,0.586,10.153,0.586,15.3
                        c0,4.455-0.389,9.647-1.518,15.299c16.064-2.497,30.815-6.128,43.488-10.794c42.626-15.694,51.573-38.891,51.573-55.586
                        C459.863,265.52,434.565,220.85,395.988,193.978z"/>
                    <path d="M311.244,15.147c-18.734,0-36.411,7.436-50.724,21.145c5.632,7.212,10.553,15.004,14.733,23.246
                        c9.592-10.94,22.195-17.602,35.991-17.602c29.955,0,54.325,31.352,54.325,69.888s-24.37,69.888-54.325,69.888
                        c-9.01,0-17.507-2.853-24.995-7.868c-2.432,8.863-5.627,17.42-9.53,25.565c10.642,5.952,22.36,9.093,34.525,9.093
                        c45.83,0,81.115-44.3,81.115-96.678C392.359,59.441,357.069,15.147,311.244,15.147z"/>
                    <path d="M259.999,226.28c-6.487,8.205-13.385,15.089-20.57,20.892c40.84,24.367,68.257,68.991,68.257,119.904
                        c0,17.196-24.104,28.639-38.472,33.929c-26.025,9.583-62.857,15.078-101.053,15.078c-38.196,0-75.029-5.495-101.054-15.078
                        c-14.368-5.29-38.472-16.732-38.472-33.929c0-50.914,27.417-95.538,68.257-119.904c-7.184-5.802-14.083-12.687-20.57-20.892
                        C30.403,256.335,0,308.218,0,367.077c0,18.127,9.926,43.389,57.213,60.8c29.496,10.861,68.898,16.841,110.947,16.841
                        c42.049,0,81.451-5.98,110.947-16.841c47.287-17.411,57.213-42.673,57.213-60.8C336.32,308.218,305.918,256.335,259.999,226.28z"
                        />
                    <path d="M168.16,242.764c53.003,0,93.806-51.234,93.806-111.804c0-60.571-40.808-111.804-93.806-111.804
                        c-52.995,0-93.806,51.223-93.806,111.804C74.354,191.542,115.169,242.764,168.16,242.764z M168.16,47.79
                        c35.936,0,65.171,37.31,65.171,83.169s-29.236,83.169-65.171,83.169s-65.171-37.31-65.171-83.169S132.225,47.79,168.16,47.79z"/>
                    </svg>
                </button>
                <button id="Time">
                    <svg viewBox="0 0 32 32">
                    <path d="M16,31.36C7.53,31.36,0.64,24.47,0.64,16S7.53,0.64,16,0.64S31.36,7.53,31.36,16S24.47,31.36,16,31.36z
                        M15.64,28h0.72v2.636c7.788-0.188,14.087-6.488,14.276-14.276H28v-0.72h2.636C30.447,7.853,24.147,1.553,16.36,1.364V4h-0.72V1.364
                        C7.853,1.553,1.553,7.853,1.364,15.64H4v0.72H1.364c0.189,7.788,6.488,14.087,14.276,14.276V28z M22.748,20.312l-7.108-4.104V6h0.72
                        v9.792l6.748,3.896L22.748,20.312z"/>
                    </svg>
                </button>
                <button id="Priority">
                    <svg viewBox="0 0 472.615 472.615">
                    <path d="M192.029,226.462v-48.072H76.202v48.072H0v19.692h76.202v48.067h115.827v-48.067h280.587v-19.692H192.029z
                            M172.337,274.529H95.894v-76.447h76.442V274.529z"/>
                    <path d="M362.49,398.284v-48.067H246.663v48.067H0v19.692h246.663v48.072H362.49v-48.072h110.125v-19.692H362.49z
                            M342.798,446.356h-76.442v-76.447h76.442V446.356z"/>
                    <path d="M265.548,54.635V6.567H149.712v48.067H0v19.692h149.712v48.072h115.837V74.327h207.067V54.635H265.548z M245.856,102.707
                        h-76.452V26.26h76.452V102.707z"/>
                    </svg>
                </button>
            </div>
        </section>
    </body>
</html>
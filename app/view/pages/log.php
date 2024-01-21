<!DOCTYPE html>
<html>
    <head>
    <?php include_once __DIR__ . '/components/common/head.php' ?>
    </head>
    <body class="log">
    <?php include_once __DIR__ . '/components/common/header.php' ?>
        <main>
            <form action="#" method="POST">
                <div>
                    <p>Логин</p>
                    <input type="text">
                </div>
                <div>
                    <p>Пароль</p>
                    <div>
                        <input type="password">
                    </div>
                </div>
                <button>Войти</button>
                <a href="../reg/view">Нет аккаунта</a>
            </form>
        </main>
    </body>
</html>
<!DOCTYPE html>
<html>
    <head>
    <?php include_once __DIR__ . '/components/common/head.php' ?>
    </head>
    <body class="reg">
    <?php include_once __DIR__ . '/components/common/header.php' ?>
        <main>
            <form action="../calendar/view" method="POST">
                <div>
                    <p>E-mail</p>
                    <input type="text" name="email">
                </div>
                <div>
                    <p>Логин</p>
                    <input type="text" name="login">
                </div>
                <div>
                    <p>Имя</p>
                    <input type="text" name="name">
                </div>
                <div>
                    <p>Пароль</p>
                    <input type="password" name="password1">
                </div>
                <div>
                    <p>Повтор</p>
                    <input type="password" name="password2">
                </div>
                <button>Зарегистрироваться</button>
            </form>
        </main>
    </body>
</html>
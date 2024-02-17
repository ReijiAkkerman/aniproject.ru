<?php
    namespace tests\Integration;

    require_once __DIR__ . "/../../vendor/autoload.php";

    use project\control\Reg;
    use PHPUnit\Framework\TestCase;

    class RegTest extends TestCase {
        private function testIsNewUser(): void {
            // Входные данные 

            $_POST['email'] = 'reijiakkerman@gmail.com';
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['name'] = 'Reiji';
            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = 'KisaragiEki4';

            // Подготовка 

            $obj = new Reg();
            $obj->getFieldValues();

            // Подтверждение при отсутствии БД и зарегистрированных пользователей

            $this->assertFalse($obj->isUser('mysql', '%'));

            // Подтверждение при наличии БД и отсутствии зарегистрированных пользователей

            $this->assertFalse($obj->isUser('mysql', '%'));

            // Подтверждение при наличии БД и зарегистрированных пользователей

            $obj->registrate('mysql');
            $this->assertTrue($obj->isUser('mysql', '%'));
            $error = urlencode("Внимание! Указанная почта уже используется!\nВнимание! Указанный логин уже занят!\n");
            $this->assertSame($obj->error_message, $error);
        }

        private function testRegistrate(): void {
            // Входные данные 

            $_POST['email'] = 'reijiakkerman@gmail.com';
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['name'] = 'Reiji';
            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = 'KisaragiEki4';

            // Подготовка к регистрации

            $obj = new Reg();
            $obj->getFieldValues();

            // Регистрация пользователя 

            $obj->registrate('mysql');

            // Подготовка к подтверждению

            $mysql = new \mysqli('mysql', 'root', 'KisaragiEki4');

            // Подтверждение регистрации пользователя

            $query = "SELECT * FROM Users.users WHERE ID=1";
            $data = $mysql->query($query);
            foreach($data as $row) {
                $this->assertSame($_POST['email'], $row['email']);
                $this->assertSame($_POST['login'], $row['login']);
                $this->assertSame($_POST['name'], $row['name']);
                $this->assertSame($obj->password, $row['password']);
            }
            $users = ['Entries', 'Words'];
            for($i = 0; $i < sizeof($users); $i++) {
                $query = "SHOW TABLES IN {$users[$i]}";
                $data = $mysql->query($query);
                foreach($data as $row) {
                    $this->assertSame($obj->login, $row["Tables_in_{$users[$i]}"]);
                }
            }

            $mysql->close();
        }

        private function testInit(): void {
            // Подготовка

            $databases = ['Users', 'Entries', 'Words'];
            $users = ['Users', 'Entries', 'Words'];
            $databases_assertion = sizeof($databases);
            $users_assertion = sizeof($users);
            $table_assertion = false;
            $counter = 0;
            
            // Инициализация

            $obj = new Reg();
            $obj->init('mysql', '%');
            $mysql = new \mysqli('mysql', 'root', 'KisaragiEki4');
            
            // Подтверждение создания БД

            $query = "SHOW DATABASES";
            $data = $mysql->query($query);
            foreach($data as $row) {
                if(in_array($row['Database'], $databases))
                    $counter++;
            }
            $this->assertSame($databases_assertion, $counter);

            // Подтверждение создания пользователей

            $counter = 0;
            $query = "SELECT user FROM mysql.user";
            $data = $mysql->query($query);
            foreach($data as $row) {
                if(in_array($row['user'], $users))
                    $counter++;
            }
            $this->assertSame($users_assertion, $counter);

            // Подтверждение создания таблиц
            
            $query = "SHOW TABLES IN Users";
            $data = $mysql->query($query);
            foreach($data as $row) {
                if($row['Tables_in_Users'] === 'users')
                    $table_assertion = true;
            }
            $this->assertTrue($table_assertion);
            
            $mysql->close();
        }
    }
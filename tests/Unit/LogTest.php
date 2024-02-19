<?php
    namespace tests\Unit;

    require_once __DIR__ . "/../../vendor/autoload.php";

    use PHPUnit\Framework\TestCase;
    use project\control\Log;
    use project\control\enum\Regex;

    class LogTest extends TestCase {
        public function testGetFieldsContent(): void {
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['password'] = 'KisaragiEki4';
            $obj = new Log();
            $obj->getFieldsContent();
            $this->assertSame('ReijiAkkerman', $obj->login);
            $this->assertSame('KisaragiEki4', $obj->password);
        }

        public function testVerifyFieldsContent(): void {
            $_POST['login'] = 'reijiakkerman@gmail.com';
            $_POST['password'] = 'KisaragiEki4';
            $obj = new Log();
            $result = $obj->verifyFieldsContent();
            $this->assertTrue($result);
            unset($obj);
            
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['password'] = 'KisaragiEki4';
            $obj = new Log();
            $result = $obj->verifyFieldsContent();
            $this->assertTrue($result);
            unset($obj);

            $_POST['login'] = 'ReijiAkkerman()';
            $_POST['password'] = 'KisaragiEki4()';
            $obj = new Log();
            $result = $obj->verifyFieldsContent();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame("Внимание! Поле 'Логин' содержит недопустимые символы или длину!\nВнимание! Поле 'Пароль' содержит недопустимые символы или длину!\n", $error_message);
            unset($obj);

            $_POST['login'] = 'Rey';
            $_POST['password'] = 'Rey';
            $obj = new Log();
            $result = $obj->verifyFieldsContent();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame("Внимание! Поле 'Логин' содержит недопустимые символы или длину!\nВнимание! Поле 'Пароль' содержит недопустимые символы или длину!\n", $error_message);
            unset($obj);

            $_POST['login'] = '';
            $_POST['password'] = '';
            $obj = new Log();
            $result = $obj->verifyFieldsContent();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame("Внимание! Поле 'Логин' содержит недопустимые символы или длину!\nВнимание! Поле 'Пароль' содержит недопустимые символы или длину!\n", $error_message);
            unset($obj);
        }

        public function testCheckFieldsContent(): void {
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['password'] = 'KisaragiEki4';
            $obj = new Log();
            $result = $obj->checkFieldsContent();
            $this->assertTrue($result);
            
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['password'] = '';
            $last_error = '';
            $result = $obj->checkFieldsContent();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Поле 'Пароль' не заполнено!\n", $error_message);
            $last_error = $error_message;

            $_POST['login'] = '';
            $_POST['password'] = 'KisaragiEki4';
            $result = $obj->checkFieldsContent();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Поле 'Логин' не заполнено!\n", $error_message);
            $last_error = $error_message;

            $_POST['login'] = '';
            $_POST['password'] = '';
            $result = $obj->checkFieldsContent();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Поле 'Логин' не заполнено!\nВнимание! Поле 'Пароль' не заполнено!\n", $error_message);
            $last_error = $error_message;
        }

        public function testCheckFieldsNames(): void {
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['password'] = 'KisaragiEki4';
            $obj = new Log();
            $result = $obj->checkFieldsNames();
            $this->assertTrue($result);
            unset($obj);
            unset($_POST['login']);
            unset($_POST['password']);

            $_POST['login'] = 'ReijiAkkerman';
            $_POST['password1'] = 'KisaragiEki4';
            $obj = new Log();
            $result = $obj->checkFieldsNames();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame("Ошибка!!! Данные от поля 'Пароль' не получены!!!\n", $error_message);
            unset($obj);
            unset($_POST['login']);
            unset($_POST['password1']);

            $_POST['login1'] = 'ReijiAkkerman';
            $_POST['password'] = 'KisaragiEki4';
            $obj = new Log();
            $result = $obj->checkFieldsNames();
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame("Ошибка!!! Данные от поля 'Логин' не получены!!!\n", $error_message);
            unset($obj);
            unset($_POST['login']);
            unset($_POST['password1']);

            $_POST['login'] = '';
            $_POST['password'] = '';
            $obj = new Log();
            $result = $obj->checkFieldsNames();
            $this->assertTrue($result);
            unset($obj);
            unset($_POST['login']);
            unset($_POST['password']);
        }





        public function testGetFieldLabel(): void {
            $array = [
                'login',
                'password',
                'password1'
            ];
            $values = [
                'Логин',
                'Пароль'
            ];
            $obj = new Log();
            for($i = 0; $i < sizeof($values); $i++) {
                $result = $obj->getFieldLabel($array[$i]);
                $this->assertIsString($result);
                $this->assertSame($values[$i], $result);
            }
            $result = $obj->getfieldLabel(end($array));
            $this->assertFalse($result);
        }

        public function testGetRegex(): void {
            $array = [
                'email',
                'login',
                'password',
                'password1'
            ];
            $obj = new Log();
            for($i = 0; $i < sizeof($array) - 1; $i++) {
                $result = $obj->getRegex($array[$i]);
                $this->assertInstanceOf(Regex::class, $result);
            }
            $result = $obj->getRegex(end($array));
            $this->assertFalse(false, $result);
        }

        public function testDefineLoginType(): void {
            $obj = new Log();
            $result = $obj->defineLoginType('reijiakkerman@gmail.com');
            $this->assertSame('email', $result);
            $result = $obj->defineLoginType('ReijiAkkerman');
            $this->assertSame('login', $result);
        }
    }
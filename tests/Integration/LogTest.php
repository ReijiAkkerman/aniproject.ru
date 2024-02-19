<?php
    namespace tests\Integration;

    require_once __DIR__ . "/../../vendor/autoload.php";

    use project\control\Log;
    use PHPUnit\Framework\TestCase;

    class LogTest extends TestCase {
        public function testComparePassword(): void {
            $obj = new Log();

            $login = 'ReijiAkkermann';
            $password = 'deletedpassword';
            $loginType = 'login';
            $result = $obj->comparePassword($login, $password, $loginType);
            $this->assertTrue($result);

            $login = 'ReijiAkkermann';
            $password = 'KisaragiEki4';
            $loginType = 'login';
            $result = $obj->comparePassword($login, $password, $loginType);
            $this->assertFalse($result);

            $login = 'ReijiAkkermann';
            $password = 'deletedpassword';
            $loginType = 'email';
            $result = $obj->comparePassword($login, $password, $loginType);
            $this->assertFalse($result);
        }

        public function testIsUser(): void {
            $obj = new Log();

            $login = 'ReijiAkkermann';
            $loginType = 'login';
            $result = $obj->isUser($login, $loginType);
            $this->assertTrue($result);

            $login = 'reijiakkerman@gmail.com';
            $loginType = 'email';
            $result = $obj->isUser($login, $loginType);
            $this->assertTrue($result);

            $login = 'reijiakkerman@gmail.co';
            $loginType = 'email';
            $last_error = '';
            $result = $obj->isUser($login, $loginType);
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Указанный пользователь не найден!\n", $error_message);
            $last_error = $error_message;

            $login = 'reijiakkerman@gmail.com';
            $loginType = 'login';
            $result = $obj->isUser($login, $loginType);
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Указанный пользователь не найден!\n", $error_message);
            $last_error = $error_message;

            $login = '';
            $loginType = 'email';
            $result = $obj->isUser($login, $loginType);
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Указанный пользователь не найден!\n", $error_message);
            $last_error = $error_message;

            $login = '';
            $loginType = 'login';
            $result = $obj->isUser($login, $loginType);
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Указанный пользователь не найден!\n", $error_message);
            $last_error = $error_message;

            $login = 'reijiakkerman@gmail.com()';
            $loginType = 'email';
            $result = $obj->isUser($login, $loginType);
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Указанный пользователь не найден!\n", $error_message);
            $last_error = $error_message;

            $login = 'ReijiAkkermann()';
            $loginType = 'login';
            $result = $obj->isUser($login, $loginType);
            $this->assertFalse($result);
            $error_message = urldecode($obj->error_message);
            $this->assertSame($last_error . "Внимание! Указанный пользователь не найден!\n", $error_message);
            $last_error = $error_message;
        }

        public function testGetUserID(): void {
            $obj = new Log();
            $result = $obj->getUserID('ReijiAkkermann', 'login');
            $this->assertIsInt($result);
            $this->assertSame(1, $result);
        }
    }
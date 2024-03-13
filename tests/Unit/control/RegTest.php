<?php
    namespace tests\Unit\control;

    require_once __DIR__ . "/../../vendor/autoload.php";

    use PHPUnit\Framework\TestCase;
    use project\control\Reg;
    use project\control\enum\Regex;

    class RegTest extends TestCase {
        public function testGetFieldValues(): void {
            $_POST['email'] = 'reijiakkerman@gmail.com';
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['name'] = 'Reiji';
            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = 'KisaragiEki4';
            $obj = new Reg();
            $result = $obj->getFieldValues();
            $this->assertTrue($result);
            unset($obj);

            $_POST['email'] = 'reijiakkerman@gmail.com';
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['name'] = 'Reiji';
            $_POST['password1'] = 'Kisaragi';
            $_POST['password2'] = 'KisaragiEki4';
            $obj = new Reg();
            $result = $obj->getFieldValues();
            $this->assertFalse($result);
            unset($obj);

            $_POST['email'] = 'reijiakkerman@gmail.com-';
            $_POST['login'] = 'ReijiAkkerman-';
            $_POST['name'] = 'Reiji-';
            $_POST['password1'] = 'KisaragiEki4-';
            $_POST['password2'] = 'KisaragiEki4-';
            $obj = new Reg();
            $result = $obj->getFieldValues();
            $this->assertFalse($result);
            unset($obj);

            $_POST['email'] = '';
            $_POST['login'] = '';
            $_POST['name'] = '';
            $_POST['password1'] = '';
            $_POST['password2'] = '';
            $obj = new Reg();
            $result = $obj->getFieldValues();
            $this->assertFalse($result);
            echo urldecode($obj->error_message);
            unset($obj);
        }

        public function testIsGoodField(): void {
            $obj = new Reg();
            $_POST['email'] = 'reijiakkerman@gmail.com';
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['name'] = 'Reiji';
            $_POST['password1'] = '';
            $_POST['password2'] = 'Kisaragi(Eki)4';
            $fields = [
                'email',
                'login',
                'name',
                'password1',
                'password2',
                'password3',
                ''
            ];
            $i = 0;
            while($i != 3) {
                $fieldName = $fields[$i];
                $result = $obj->isGoodField($fieldName);
                $this->assertTrue($result);
                $i++;
            }

            $fieldName = $fields[$i];
            $result = $obj->isGoodField($fieldName);
            $field = $obj->getFieldName($fieldName);
            $this->assertFalse($result);
            $this->assertSame("Внимание! Поле '{$field}' не заполнено!\n", urldecode($obj->error_message));
            $last_error_message = $obj->error_message;
            $i++;            

            $fieldName = $fields[$i];
            $result = $obj->isGoodField($fieldName);
            $field = $obj->getFieldName($fieldName);
            $this->assertFalse($result);
            $this->assertSame(urldecode($last_error_message) . "Внимание! Поле '{$field}' имеет недопустимые символы или длину!\n", urldecode($obj->error_message));
            $last_error_message = $obj->error_message;
            $i++;

            while($i != 7) {
                $fieldName = $fields[$i];
                $result = $obj->isGoodField($fieldName);
                $field = $obj->getFieldName($fieldName);
                $this->assertFalse($result);
                $this->assertSame(urldecode($last_error_message) . "Ошибка!!! Поле '{$field}' не найдено!!!\n", urldecode($obj->error_message));
                $last_error_message = $obj->error_message;
                $i++;
            }
        }

        public function testGetFieldName(): void {
            $obj = new Reg();
            $fieldNames = [
                'email',
                'login',
                'name',
                'password1',
                'password2',
                'password3'
            ];
            $answers = [
                'E-mail',
                'Логин',
                'Имя',
                'Пароль',
                'Повтор'
            ];
            for($i = 0; $i < sizeof($fieldNames) - 1; $i++) {
                $result = $obj->getFieldName($fieldNames[$i]);
                $this->assertSame($answers[$i], $result);
            }
            $result = $obj->getFieldName(end($fieldNames));
            $this->assertFalse($result);
        }

        public function testGetRegex(): void {
            $obj = new Reg();
            $fieldNames = [
                'email',
                'login',
                'name',
                'password',
                'password1'
            ];
            for($i = 0; $i < sizeof($fieldNames) - 1; $i++) {
                $result = $obj->getRegex($fieldNames[$i]);
                $this->assertInstanceOf(Regex::class, $result);
            }
            $result = $obj->getRegex(end($fieldNames));
            $this->assertFalse($result);
        }

        public function testGetPassword(): void {
            $obj = new Reg();

            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = 'KisaragiEki4';
            $result = $obj->getPassword();
            $this->assertIsString($result);
            $this->assertMatchesRegularExpression('#\$2y\$10\$.+#', $result);

            $_POST['password1'] = '';
            $_POST['password2'] = 'KisaragiEki4';
            $result = $obj->getPassword();
            $this->assertFalse($result);

            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = '';
            $result = $obj->getPassword();
            $this->assertFalse($result);

            $_POST['password1'] = '';
            $_POST['password2'] = '';
            $result = $obj->getPassword();
            $this->assertFalse($result);

            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = 'some_another_password';
            $result = $obj->getPassword();
            $this->assertFalse($result);
        }

        public function testComparePasswords(): void {
            $password1 = ['hello', '', 'hello', '', 'hello1'];
            $password2 = ['hello', 'hello', '', '', 'hello2'];
            $obj = new Reg();
            $result = $obj->comparePasswords($password1[0], $password2[0]);
            $this->assertIsString($result);
            $result = $obj->comparePasswords($password1[1], $password2[1]);
            $this->assertFalse($result);
            $result = $obj->comparePasswords($password1[2], $password2[2]);
            $this->assertFalse($result);
            $result = $obj->comparePasswords($password1[3], $password2[3]);
            $this->assertIsString($result);
            $result = $obj->comparePasswords($password1[4], $password2[4]);
            $this->assertFalse($result);
        }

        public function testEncryptPassword(): void {
            $password = 'KisaragiEki4';
            $obj = new Reg();
            $hashed_pasword = $obj->encryptPassword($password);
            $this->assertMatchesRegularExpression('#\$2y\$10\$.+#', $hashed_pasword);
        }
    }
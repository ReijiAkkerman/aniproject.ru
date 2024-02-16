<?php
    namespace tests\Unit;

    require_once __DIR__ . "/../../vendor/autoload.php";

    use PHPUnit\Framework\TestCase;
    use project\control\Reg;
    use project\control\enum\Regex;

    class RegTest extends TestCase {
        private function testGetFieldValues() {
            $_POST['email'] = 'reijiakkerman@gmail.com';
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['name'] = 'Reiji';
            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = 'KisaragiEki4';
            $obj = new Reg();
            $this->assertIsString($obj->email);
            $this->assertIsString($obj->login);
            $this->assertIsString($obj->name);
            $this->assertIsString($obj->password);
            $this->assertTrue($obj->getFieldValues());
        }

        private function testGetValues(): void {
            $_POST['email'] = 'reijiakkerman@gmail.com';
            $_POST['login'] = 'ReijiAkkerman';
            $_POST['name'] = 'Reiji';
            $_POST['password1'] = 'KisaragiEki4';
            $_POST['password2'] = '';
            $obj = new Reg;
            $obj->fields = [
                'email',
                'login',
                'name',
                'password1',
                'password2'
            ];
            $this->assertFalse($obj->getValues());
            $_POST['password2'] = 'KisaragiEki4';
            $this->assertIsArray($obj->getValues());
        }

        private function testValidateField(): void {
            $obj = new Reg;
            $fields = [
                'email',
                'login',
                'name',
                'password'
            ];
            $fields_values = [
                'reijiakkerman@gmail.com',
                'ReijiAkkerman',
                'Reiji',
                'KisaragiEki4'
            ];
            for($i = 0; $i < sizeof($fields); $i++) {
                $this->assertIsString($obj->validateField($obj->getRegex($fields[$i]), $fields_values[$i]));
                $this->assertFalse($obj->validateField($obj->getRegex($fields[$i])));
            }
        }

        private function testGetRegex(): void {
            $obj = new Reg;
            $fields = [
                'none',
                'email',
                'login',
                'name',
                'password'
            ];
            $this->assertFalse($obj->getRegex($fields[0]));
            for($i = 1; $i < sizeof($fields); $i++) {
                $this->assertIsObject($obj->getRegex($fields[$i]));
            }
        }

        private function testComparePasswords(): void {
            $obj = new Reg;
            $password = 'some_password';
            $this->assertFalse($obj->comparePasswords($password));
            $this->assertFalse($obj->comparePasswords('', $password));
            $this->assertFalse($obj->comparePasswords());
            $this->assertEquals($password, $obj->comparePasswords($password, $password));
        }

        private function testGetPassword(): void {
            $obj = new Reg;
            $password1 = ['some_password', '', 'some_password', ''];
            $password2 = ['some_password', 'some_password', '', ''];
            for($i = 1; $i < sizeof($password1); $i++) {
                $this->assertFalse($obj->getPassword($password1[$i], $password2[$i]));
            }
            $this->assertIsString($obj->getPassword($password1[0], $password2[0]));
            $this->assertMatchesRegularExpression('#\$2y\$10\$.+#', $obj->getPassword($password1[0], $password2[0]));
        }
    }
<?php
    namespace tests\Unit;

    require_once __DIR__ . "/../../vendor/autoload.php";

    use PHPUnit\Framework\TestCase;
    use project\control\Reg;

    class RegTest extends TestCase {
        public function testComparePasswords(): void {
            $obj = new Reg;
            $password = 'some_password';
            $this->assertFalse($obj->comparePasswords($password));
            $this->assertFalse($obj->comparePasswords('', $password));
            $this->assertFalse($obj->comparePasswords());
            $this->assertEquals($password, $obj->comparePasswords($password, $password));
        }

        public function testGetPassword(): void {
            $obj = new Reg;
            $password1 = ['some_password', '', 'some_password', ''];
            $password2 = ['some_password', 'some_password', '', ''];
            for($i = 1; $i < sizeof($password1); $i++) {
                $this->assertFalse($obj->getPassword($password1[$i], $password2[$i]));
            }
            $this->assertMatchesRegularExpression('#\$2y\$10\$.+#', $obj->getPassword($password1[0], $password2[0]));
        }
    }
<?php

class CheckTest extends PHPUnit_Framework_TestCase
{

    public function testIs10()
    {
        $this->assertTrue(Isbn\Check::is10('8881837188'));
        $this->assertFalse(Isbn\Check::is10('888183718'));
    }

    public function testIs13()
    {
        $this->assertTrue(Isbn\Check::is13('9788889527191'));
        $this->assertFalse(Isbn\Check::is13('978888952719'));
    }

    public function testIdentify()
    {
        $this->assertEquals('10', Isbn\Check::identify('8881837188'));
        $this->assertFalse(Isbn\Check::identify('888183718'));
        $this->assertEquals('13', Isbn\Check::identify('9788889527191'));
        $this->assertFalse(Isbn\Check::identify('978888952719'));
    }

}

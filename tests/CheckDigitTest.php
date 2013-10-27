<?php
class CheckDigitTest extends PHPUnit_Framework_TestCase
{

    public function testIsbn10()
    {
        $this->assertEquals('8', Isbn\CheckDigit::make10('888183718'));
        $this->assertEquals('8', Isbn\CheckDigit::make10('8881837188'));
        $this->assertEquals('0', Isbn\CheckDigit::make10('711119626'));
        $this->assertEquals('0', Isbn\CheckDigit::make10('7111196266'));
    }

    public function testIsbn13()
    {
        $this->assertEquals('1', Isbn\CheckDigit::make13('978888952719'));
        $this->assertEquals('1', Isbn\CheckDigit::make13('9788889527191'));
    }

    public function testIsbn()
    {
        $this->assertEquals('8', Isbn\CheckDigit::make('888183718'));
        $this->assertEquals('1', Isbn\CheckDigit::make('978888952719'));
        $this->assertFalse(Isbn\CheckDigit::make('97888895271921'));
    }

}

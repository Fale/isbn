<?php
class CheckDigitTest extends PHPUnit_Framework_TestCase
{

    public function testIsbn10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('8', $isbn->checkDigit->make10('888183718'));
        $this->assertEquals('8', $isbn->checkDigit->make10('8881837188'));
        $this->assertEquals('0', $isbn->checkDigit->make10('711119626'));
        $this->assertEquals('0', $isbn->checkDigit->make10('7111196266'));
    }

    public function testIsbn13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('1', $isbn->checkDigit->make13('978888952719'));
        $this->assertEquals('1', $isbn->checkDigit->make13('9788889527191'));
    }

    public function testIsbn()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('8', $isbn->checkDigit->make('888183718'));
        $this->assertEquals('1', $isbn->checkDigit->make('978888952719'));
        $this->assertFalse($isbn->checkDigit->make('97888895271921'));
    }
}

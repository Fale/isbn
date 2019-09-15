<?php
/**
 * Check Digit Test.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author linkkingjay <linkingjay@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */
class CheckDigitTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test ISBN-10.
     */
    public function testIsbn10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('8', $isbn->checkDigit->make10('888183718'));
        $this->assertEquals('8', $isbn->checkDigit->make10('8881837188'));
        $this->assertEquals('0', $isbn->checkDigit->make10('711119626'));
        $this->assertEquals('0', $isbn->checkDigit->make10('7111196266'));
    }

    /**
     * Test ISBN-13.
     */
    public function testIsbn13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('1', $isbn->checkDigit->make13('978888952719'));
        $this->assertEquals('1', $isbn->checkDigit->make13('9788889527191'));
    }

    /**
     * Test ISBN.
     */
    public function testIsbn()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('8', $isbn->checkDigit->make('888183718'));
        $this->assertEquals('1', $isbn->checkDigit->make('978888952719'));
        $this->assertFalse($isbn->checkDigit->make('97888895271921'));
    }
}

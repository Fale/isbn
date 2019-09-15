<?php
/**
 * Check Test.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */
class CheckTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test ISBN-10 Check.
     */
    public function testIs10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->check->is10('8881837188'));
        $this->assertFalse($isbn->check->is10('888183718'));
    }

    /**
     * Test ISBN-13 Check.
     */
    public function testIs13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->check->is13('9788889527191'));
        $this->assertFalse($isbn->check->is13('978888952719'));
    }

    /**
     * Test Identify.
     */
    public function testIdentify()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('10', $isbn->check->identify('8881837188'));
        $this->assertFalse($isbn->check->identify('888183718'));
        $this->assertEquals('13', $isbn->check->identify('9788889527191'));
        $this->assertFalse($isbn->check->identify('978888952719'));
    }
}

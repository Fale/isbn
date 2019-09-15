<?php
/**
 * Translate Test.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author linkkingjay <linkingjay@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */
class TranslateTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test Convert To ISBN-13.
     */
    public function testTo13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('9789880038273', $isbn->translate->to13('9880038274'));
    }

    /**
     * Test Convert To ISBN-10.
     */
    public function testTo10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('9880038274', $isbn->translate->to10('9789880038273'));
    }

    /**
     * Test Convert to ISBN-13 With Hyphens.
     */
    public function testTo13WithHyphens()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('978-7-111-19626-6', $isbn->translate->to13('7-111-19626-0'));
    }

    /**
     * Test Convert To ISBN-10 With Hypens.
     */
    public function testTo10WithHyphens()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('7-111-19626-0', $isbn->translate->to10('978-7-111-19626-6'));
    }
}

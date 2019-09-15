<?php
/**
 * Hyphens Test.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */
class HyphensTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test Remove Hyphens.
     */
    public function testRemoveHyphens()
    {
        $isbn = new Isbn\Isbn();
        // ISBN10
        $this->assertEquals('9992158107', $isbn->hyphens->removeHyphens('99921-58-10-7'));
        $this->assertEquals('9992158107', $isbn->hyphens->removeHyphens('99921 58 10 7'));
        $this->assertEquals('9971502100', $isbn->hyphens->removeHyphens('9971-5-0210-0'));
        $this->assertEquals('9971502100', $isbn->hyphens->removeHyphens('9971 5 0210 0'));
        $this->assertEquals('080442957X', $isbn->hyphens->removeHyphens('0-8044-2957-X'));
        $this->assertEquals('080442957X', $isbn->hyphens->removeHyphens('0 8044 2957 X'));
        $this->assertEquals('8535902775', $isbn->hyphens->removeHyphens('85-359-0277-5'));
        $this->assertEquals('8535902775', $isbn->hyphens->removeHyphens('85 359 0277 5'));
        $this->assertEquals('0943396042', $isbn->hyphens->removeHyphens('0-943396-04-2'));
        $this->assertEquals('0943396042', $isbn->hyphens->removeHyphens('0 943396 04 2'));

        // ISBN13
        $this->assertEquals('9786001191251', $isbn->hyphens->removeHyphens('978-600-119-125-1'));
        $this->assertEquals('9786001191251', $isbn->hyphens->removeHyphens('978 600 119 125 1'));
        $this->assertEquals('9786017151133', $isbn->hyphens->removeHyphens('978-601-7151-13-3'));
        $this->assertEquals('9786017151133', $isbn->hyphens->removeHyphens('978 601 7151 13 3'));
        $this->assertEquals('9786028328227', $isbn->hyphens->removeHyphens('978-602-8328-22-7'));
        $this->assertEquals('9786028328227', $isbn->hyphens->removeHyphens('978 602 8328 22 7'));
        $this->assertEquals('9789880038273', $isbn->hyphens->removeHyphens('978-988-00-3827-3'));
        $this->assertEquals('9789880038273', $isbn->hyphens->removeHyphens('978 988 00 3827 3'));
        $this->assertEquals('9791090636071', $isbn->hyphens->removeHyphens('979-10-90636-07-1'));
        $this->assertEquals('9791090636071', $isbn->hyphens->removeHyphens('979 10 90636 07 1'));
    }

    /**
     * Test Fix Hyphens.
     */
    public function testFixHyphens()
    {
        $isbn = new Isbn\Isbn();
        // ISBN10
        $this->assertEquals('99921-58-10-7', $isbn->hyphens->fixHyphens('9992158-10-7'));
        $this->assertEquals('99921-58-10-7', $isbn->hyphens->fixHyphens('99921 58 1-0 7'));

        // ISBN13
        $this->assertEquals('9786001191251', $isbn->hyphens->removeHyphens('978-600-119-125-1'));
        $this->assertEquals('9786001191251', $isbn->hyphens->removeHyphens('978 600-119 125 1'));
        $this->assertEquals('9786017151133', $isbn->hyphens->removeHyphens('978-601-71-5113-3'));
        $this->assertEquals('9786017151133', $isbn->hyphens->removeHyphens('978 601 715113  3'));
    }

    /**
     * Test Add Hyphens.
     */
    public function testAddHyphens()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('979-10-90636-07-1', $isbn->hyphens->addHyphens('9791090636071'));
        $this->assertEquals('99921-58-10-7', $isbn->hyphens->addHyphens('9992158107'));
        $this->assertEquals('978-988-00-3827-3', $isbn->hyphens->addHyphens('9789880038273'));
        $this->assertEquals('0-8044-2957-X', $isbn->hyphens->addHyphens('080442957X'));
        $this->assertEquals('400-739606900-6', $isbn->hyphens->addHyphens('4007396069006'));
        $this->assertEquals('978-3-0355-0366-1', $isbn->hyphens->addHyphens('9783035503661'));
        $this->assertEquals('979 10 90636 07 1', $isbn->hyphens->addHyphens('9791090636071', ' '));
        $this->assertEquals('99921 58 10 7', $isbn->hyphens->addHyphens('9992158107', ' '));
        $this->assertEquals('978 988 00 3827 3', $isbn->hyphens->addHyphens('9789880038273', ' '));
        $this->assertEquals('0 8044 2957 X', $isbn->hyphens->addHyphens('080442957X', ' '));
    }
}

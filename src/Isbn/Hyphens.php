<?php
/**
 * Hyphens
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 * @version 2.0.0
 * @package ISBN
*/
namespace Isbn;

/**
 * Hyphens
*/
class Hyphens
{
    /**
     * ISBN
     *
     * @var string
    */
    private $isbn;

    /**
     * ISBN (splitted)
     *
     * @var array
    */
    private $isbnSplit = array();

    /**
     * Remove Hyphens
     *
     * @param string $isbn
     * @return string
     * @throws Exception
    */
    public function removeHyphens($isbn)
    {
        if(is_string($isbn) === false) {
            throw new Exception('Invalid parameter type.');
        }

        $isbn = str_replace(' ', '', $isbn);
        $isbn = str_replace('-', '', $isbn);
        return $isbn;
    }

    /**
     * Fix Hypens
     *
     * @param string $isbn
     * @param string $char
     * @return string
    */
    public function fixHyphens($isbn, $char = '-')
    {
        $isbn = $this->removeHyphens($isbn);
        return $this->addHyphens($isbn, $char);
    }

    /**
     * Add Hypens
     *
     * @param string $isbn
     * @param string $char
     * @throws Exception
    */
    public function addHyphens($isbn, $char = '-')
    {
        if(is_string($isbn) === false ||
            is_string($char) === false) {
            throw new Exception('Invalid parameter type.');
        }
        
        $this->isbn = $isbn;
        $this->isbnSplit = array();
        
        if (strlen($this->isbn) === 13) {
            $this->isbnSplit[0] = substr($this->isbn, 0, 3);
        }
        
        $this->getRegistrationGroupElement();
        $this->getRegistrantElement();
        $this->getPublicationElement();
        $this->getCheckDigit();
        return implode($char, $this->isbnSplit);
    }

    /**
     * Range
     *
     * @param int $min
     * @param int $max
     * @param int $chars
     * @param int $p
     * @return boolean
     */
    private function range($min, $max, $chars, $p)
    {
        if (!$chars) {
            return false;
        }

        $val = substr($this->isbn, $this->parsed($p), $chars);
        $min = substr($min, 0, $chars);
        $max = substr($max, 0, $chars);

        if ($val >= $min and $val <= $max) {
            $this->isbnSplit[$p] = $val;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get Parsed Length
     *
     * @param null|int $now
     * @return int
    */
    private function parsed($now = null)
    {
        $chars = 0;
        foreach ($this->isbnSplit as $key => $split) {
            if (isset($now) === false or $key < $now) {
                $chars = $chars + strlen($split);
            }
        }

        return $chars;
    }

    /**
     * Get Registration Group Element
     *
     * @return boolean
    */
    private function getRegistrationGroupElement()
    {
        if (isset($this->isbnSplit[0]) === false or $this->isbnSplit[0] === '978') {
            $this->range(0, 5999999, 1, 1);
            $this->range(6000000, 6499999, 3, 1);
            $this->range(6500000, 6999999, 0, 1);
            $this->range(7000000, 7999999, 1, 1);
            $this->range(8000000, 9499999, 2, 1);
            $this->range(9500000, 9899999, 3, 1);
            $this->range(9900000, 9989999, 4, 1);
            $this->range(9990000, 9999999, 5, 1);
        }

        if (isset($this->isbnSplit[0]) === true and $this->isbnSplit[0] === '979') {
            $this->range(0, 999999, 0, 1);
            $this->range(1000000, 1199999, 2, 1);
            $this->range(1200000, 9999999, 0, 1);
        }

        return (isset($this->isbnSplit[1]));
    }

    /**
     * Get Registrant Element
    */
    private function getRegistrantElement()
    {
        if (isset($this->isbnSplit[0]) === true) {
            $soFar = implode('-', $this->isbnSplit);
        } else {
            $soFar = '978-'.$this->isbnSplit[1];
        }

        switch ($soFar) {
            case '978-0':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9499999, 6, 2);
                $this->range(9500000, 9999999, 7, 2);
                break;
            case '978-1':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 3999999, 3, 2);
                $this->range(4000000, 5499999, 4, 2);
                $this->range(5500000, 8697999, 5, 2);
                $this->range(8698000, 9989999, 6, 2);
                $this->range(9990000, 9999999, 7, 2);
                break;
            case '978-2':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 3499999, 3, 2);
                $this->range(3500000, 3999999, 5, 2);
                $this->range(4000000, 6999999, 3, 2);
                $this->range(7000000, 8399999, 4, 2);
                $this->range(8400000, 8999999, 5, 2);
                $this->range(9000000, 9499999, 6, 2);
                $this->range(9500000, 9999999, 7, 2);
                break;
            case '978-3':
                $this->range(0, 299999, 2, 2);
                $this->range(300000, 339999, 3, 2);
                $this->range(340000, 369999, 4, 2);
                $this->range(370000, 399999, 5, 2);
                $this->range(400000, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9499999, 6, 2);
                $this->range(9500000, 9539999, 7, 2);
                $this->range(9540000, 9699999, 5, 2);
                $this->range(9700000, 9899999, 7, 2);
                $this->range(9900000, 9949999, 5, 2);
                $this->range(9950000, 9999999, 5, 2);
                break;
            case '978-4':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9499999, 6, 2);
                $this->range(9500000, 9999999, 7, 2);
                break;
            case '978-5':
                $this->range(0, 49999, 5, 2);
                $this->range(50000, 99999, 4, 2);
                $this->range(100000, 1999999, 2, 2);
                $this->range(2000000, 4209999, 3, 2);
                $this->range(4210000, 4299999, 4, 2);
                $this->range(4300000, 4309999, 3, 2);
                $this->range(4310000, 4399999, 4, 2);
                $this->range(4400000, 4409999, 3, 2);
                $this->range(4410000, 4499999, 4, 2);
                $this->range(4500000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9099999, 6, 2);
                $this->range(9100000, 9199999, 5, 2);
                $this->range(9200000, 9299999, 4, 2);
                $this->range(9300000, 9499999, 5, 2);
                $this->range(9500000, 9500999, 7, 2);
                $this->range(9501000, 9799999, 4, 2);
                $this->range(9800000, 9899999, 5, 2);
                $this->range(9900000, 9909999, 7, 2);
                $this->range(9910000, 9999999, 4, 2);
                break;
            case '978-600':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 4999999, 3, 2);
                $this->range(5000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-601':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 7999999, 4, 2);
                $this->range(8000000, 8499999, 5, 2);
                $this->range(8500000, 9999999, 2, 2);
                break;
            case '978-602':
                $this->range(0, 1499999, 2, 2);
                $this->range(1500000, 1699999, 4, 2);
                $this->range(1700000, 1799999, 5, 2);
                $this->range(1800000, 1899999, 5, 2);
                $this->range(1900000, 1999999, 5, 2);
                $this->range(2000000, 7499999, 3, 2);
                $this->range(7500000, 7999999, 4, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-603':
                $this->range(0, 499999, 2, 2);
                $this->range(0500000, 4999999, 2, 2);
                $this->range(5000000, 7999999, 3, 2);
                $this->range(8000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-604':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 8999999, 2, 2);
                $this->range(9000000, 9799999, 3, 2);
                $this->range(9800000, 9999999, 4, 2);
                break;
            case '978-605':
                $this->range(0, 99999, 0, 2);
                $this->range(100000, 999999, 2, 2);
                $this->range(1000000, 3999999, 3, 2);
                $this->range(4000000, 5999999, 4, 2);
                $this->range(6000000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 2, 2);
                break;
            case '978-606':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 4999999, 2, 2);
                $this->range(5000000, 7999999, 3, 2);
                $this->range(8000000, 9199999, 4, 2);
                $this->range(9200000, 9999999, 5, 2);
                break;
            case '978-607':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 7499999, 3, 2);
                $this->range(7500000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-608':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 1999999, 2, 2);
                $this->range(2000000, 4499999, 3, 2);
                $this->range(4500000, 6499999, 4, 2);
                $this->range(6500000, 6999999, 5, 2);
                $this->range(7000000, 9999999, 1, 2);
                break;
            case '978-609':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-611':
                $this->range(0, 9999999, 0, 2);
                break;
            case '978-612':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 3999999, 3, 2);
                $this->range(4000000, 4499999, 4, 2);
                $this->range(4500000, 4999999, 5, 2);
                $this->range(5000000, 9999999, 2, 2);
                break;
            case '978-613':
                $this->range(0, 9999999, 1, 2);
                break;
            case '978-614':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-615':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 4999999, 3, 2);
                $this->range(5000000, 7999999, 4, 2);
                $this->range(8000000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 0, 2);
                break;
            case '978-616':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-617':
                $this->range(0, 4999999, 2, 2);
                $this->range(5000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-618':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 4999999, 3, 2);
                $this->range(5000000, 7999999, 4, 2);
                $this->range(8000000, 9999999, 5, 2);
                break;
            case '978-619':
                $this->range(0, 1499999, 2, 2);
                $this->range(1500000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-620':
                $this->range(0, 9999999, 1, 2);
                break;
            case '978-621':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 3999999, 0, 2);
                $this->range(4000000, 5999999, 3, 2);
                $this->range(6000000, 7999999, 0, 2);
                $this->range(8000000, 8999999, 4, 2);
                $this->range(9000000, 9499999, 0, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-7':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 4999999, 3, 2);
                $this->range(5000000, 7999999, 4, 2);
                $this->range(8000000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 6, 2);
                break;
            case '978-80':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 6, 2);
                break;
            case '978-81':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 6, 2);
                break;
            case '978-82':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 4, 2);
                $this->range(9000000, 9899999, 5, 2);
                $this->range(9900000, 9999999, 6, 2);
                break;
            case '978-83':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 5999999, 3, 2);
                $this->range(6000000, 6999999, 5, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 6, 2);
                break;
            case '978-84':
                $this->range(0, 1399999, 2, 2);
                $this->range(1400000, 1499999, 3, 2);
                $this->range(1500000, 1999999, 5, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9199999, 4, 2);
                $this->range(9200000, 9239999, 6, 2);
                $this->range(9240000, 9299999, 5, 2);
                $this->range(9300000, 9499999, 6, 2);
                $this->range(9500000, 9699999, 5, 2);
                $this->range(9700000, 9999999, 4, 2);
                break;
            case '978-85':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 5999999, 3, 2);
                $this->range(6000000, 6999999, 5, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9799999, 6, 2);
                $this->range(9800000, 9999999, 5, 2);
                break;
            case '978-86':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 5999999, 3, 2);
                $this->range(6000000, 7999999, 4, 2);
                $this->range(8000000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 6, 2);
                break;
            case '978-87':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 3999999, 0, 2);
                $this->range(4000000, 6499999, 3, 2);
                $this->range(6500000, 6999999, 0, 2);
                $this->range(7000000, 7999999, 4, 2);
                $this->range(8000000, 8499999, 0, 2);
                $this->range(8500000, 9499999, 5, 2);
                $this->range(9500000, 9699999, 0, 2);
                $this->range(9700000, 9999999, 6, 2);
                break;
            case '978-88':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 5999999, 3, 2);
                $this->range(6000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9099999, 6, 2);
                $this->range(9100000, 9299999, 3, 2);
                $this->range(9300000, 9499999, 0, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-89':
                $this->range(0, 2499999, 2, 2);
                $this->range(2500000, 5499999, 3, 2);
                $this->range(5500000, 8499999, 4, 2);
                $this->range(8500000, 9499999, 5, 2);
                $this->range(9500000, 9699999, 6, 2);
                $this->range(9700000, 9899999, 5, 2);
                $this->range(9900000, 9999999, 3, 2);
                break;
            case '978-90':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 4999999, 3, 2);
                $this->range(5000000, 6999999, 4, 2);
                $this->range(7000000, 7999999, 5, 2);
                $this->range(8000000, 8499999, 6, 2);
                $this->range(8500000, 8999999, 4, 2);
                $this->range(9000000, 9099999, 2, 2);
                $this->range(9100000, 9399999, 0, 2);
                $this->range(9400000, 9499999, 2, 2);
                $this->range(9500000, 9999999, 0, 2);
                break;
            case '978-91':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 4999999, 2, 2);
                $this->range(5000000, 6499999, 3, 2);
                $this->range(6500000, 6999999, 0, 2);
                $this->range(7000000, 7999999, 4, 2);
                $this->range(8000000, 8499999, 0, 2);
                $this->range(8500000, 9499999, 5, 2);
                $this->range(9500000, 9699999, 0, 2);
                $this->range(9700000, 9999999, 6, 2);
                break;
            case '978-92':
                $this->range(0, 5999999, 1, 2);
                $this->range(6000000, 7999999, 2, 2);
                $this->range(8000000, 8999999, 3, 2);
                $this->range(9000000, 9499999, 4, 2);
                $this->range(9500000, 9899999, 5, 2);
                $this->range(9900000, 9999999, 6, 2);
                break;
            case '978-93':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 4999999, 3, 2);
                $this->range(5000000, 7999999, 4, 2);
                $this->range(8000000, 9499999, 5, 2);
                $this->range(9500000, 9999999, 6, 2);
                break;
            case '978-94':
                $this->range(0, 5999999, 3, 2);
                $this->range(6000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-950':
                $this->range(0, 4999999, 2, 2);
                $this->range(5000000, 8999999, 3, 2);
                $this->range(9000000, 9899999, 4, 2);
                $this->range(9900000, 9999999, 5, 2);
                break;
            case '978-951':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 5499999, 2, 2);
                $this->range(5500000, 8899999, 3, 2);
                $this->range(8900000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-952':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 4999999, 3, 2);
                $this->range(5000000, 5999999, 4, 2);
                $this->range(6000000, 6599999, 2, 2);
                $this->range(6600000, 6699999, 4, 2);
                $this->range(6700000, 6999999, 5, 2);
                $this->range(7000000, 7999999, 4, 2);
                $this->range(8000000, 9499999, 2, 2);
                $this->range(9500000, 9899999, 4, 2);
                $this->range(9900000, 9999999, 5, 2);
                break;
            case '978-953':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 1499999, 2, 2);
                $this->range(1500000, 5099999, 3, 2);
                $this->range(5100000, 5499999, 2, 2);
                $this->range(5500000, 5999999, 5, 2);
                $this->range(6000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-954':
                $this->range(0, 2899999, 2, 2);
                $this->range(2900000, 2999999, 4, 2);
                $this->range(3000000, 7999999, 3, 2);
                $this->range(8000000, 8999999, 4, 2);
                $this->range(9000000, 9299999, 5, 2);
                $this->range(9300000, 9999999, 4, 2);
                break;
            case '978-955':
                $this->range(0, 1999999, 4, 2);
                $this->range(2000000, 4399999, 2, 2);
                $this->range(4400000, 4499999, 5, 2);
                $this->range(4500000, 4999999, 4, 2);
                $this->range(5000000, 5499999, 5, 2);
                $this->range(5500000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-956':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 9999999, 4, 2);
                break;
            case '978-957':
                $this->range(0, 299999, 2, 2);
                $this->range(300000, 499999, 4, 2);
                $this->range(500000, 1999999, 2, 2);
                $this->range(2000000, 2099999, 4, 2);
                $this->range(2100000, 2799999, 2, 2);
                $this->range(2800000, 3099999, 5, 2);
                $this->range(3100000, 4399999, 2, 2);
                $this->range(4400000, 8199999, 3, 2);
                $this->range(8200000, 9699999, 4, 2);
                $this->range(9700000, 9999999, 5, 2);
                break;
            case '978-958':
                $this->range(0, 5699999, 2, 2);
                $this->range(5700000, 5999999, 5, 2);
                $this->range(6000000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-959':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 9999999, 5, 2);
                break;
            case '978-960':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6599999, 3, 2);
                $this->range(6600000, 6899999, 4, 2);
                $this->range(6900000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 9299999, 5, 2);
                $this->range(9300000, 9399999, 2, 2);
                $this->range(9400000, 9799999, 4, 2);
                $this->range(9800000, 9999999, 5, 2);
                break;
            case '978-961':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 5999999, 3, 2);
                $this->range(6000000, 8999999, 4, 2);
                $this->range(9000000, 9499999, 5, 2);
                $this->range(9500000, 9999999, 0, 2);
                break;
            case '978-962':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8699999, 5, 2);
                $this->range(8700000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-963':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-964':
                $this->range(0, 1499999, 2, 2);
                $this->range(1500000, 2499999, 3, 2);
                $this->range(2500000, 2999999, 4, 2);
                $this->range(3000000, 5499999, 3, 2);
                $this->range(5500000, 8999999, 4, 2);
                $this->range(9000000, 9699999, 5, 2);
                $this->range(9700000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-965':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 5999999, 3, 2);
                $this->range(6000000, 6999999, 0, 2);
                $this->range(7000000, 7999999, 4, 2);
                $this->range(8000000, 8999999, 0, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-966':
                $this->range(0, 1299999, 2, 2);
                $this->range(1300000, 1399999, 3, 2);
                $this->range(1400000, 1499999, 2, 2);
                $this->range(1500000, 1699999, 4, 2);
                $this->range(1700000, 1999999, 3, 2);
                $this->range(2000000, 2789999, 4, 2);
                $this->range(2790000, 2899999, 3, 2);
                $this->range(2900000, 2999999, 4, 2);
                $this->range(3000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 4, 2);
                $this->range(9000000, 9099999, 5, 2);
                $this->range(9100000, 9499999, 3, 2);
                $this->range(9500000, 9799999, 5, 2);
                $this->range(9800000, 9999999, 3, 2);
                break;
            case '978-967':
                $this->range(0, 99999, 2, 2);
                $this->range(100000, 999999, 4, 2);
                $this->range(1000000, 1999999, 5, 2);
                $this->range(2000000, 2999999, 0, 2);
                $this->range(3000000, 4999999, 3, 2);
                $this->range(5000000, 5999999, 4, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9899999, 3, 2);
                $this->range(9900000, 9989999, 4, 2);
                $this->range(9990000, 9999999, 5, 2);
                break;
            case '978-968':
                $this->range(0100000, 3999999, 2, 2);
                $this->range(4000000, 4999999, 3, 2);
                $this->range(5000000, 7999999, 4, 2);
                $this->range(8000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-969':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 3999999, 2, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 4, 2);
                break;
            case '978-970':
                $this->range(0100000, 5999999, 2, 2);
                $this->range(6000000, 8999999, 3, 2);
                $this->range(9000000, 9099999, 4, 2);
                $this->range(9100000, 9699999, 5, 2);
                $this->range(9700000, 9999999, 4, 2);
                break;
            case '978-971':
                $this->range(0, 159999, 3, 2);
                $this->range(160000, 199999, 4, 2);
                $this->range(200000, 299999, 2, 2);
                $this->range(300000, 599999, 4, 2);
                $this->range(600000, 999999, 2, 2);
                $this->range(1000000, 4999999, 2, 2);
                $this->range(5000000, 8499999, 3, 2);
                $this->range(8500000, 9099999, 4, 2);
                $this->range(9100000, 9599999, 5, 2);
                $this->range(9600000, 9699999, 4, 2);
                $this->range(9700000, 9899999, 2, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-972':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 5499999, 2, 2);
                $this->range(5500000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-973':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 1699999, 3, 2);
                $this->range(1700000, 1999999, 4, 2);
                $this->range(2000000, 5499999, 2, 2);
                $this->range(5500000, 7599999, 3, 2);
                $this->range(7600000, 8499999, 4, 2);
                $this->range(8500000, 8899999, 5, 2);
                $this->range(8900000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-974':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 4, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9499999, 5, 2);
                $this->range(9500000, 9999999, 4, 2);
                break;
            case '978-975':
                $this->range(0, 199999, 5, 2);
                $this->range(0200000, 2499999, 2, 2);
                $this->range(2500000, 5999999, 3, 2);
                $this->range(6000000, 9199999, 4, 2);
                $this->range(9200000, 9899999, 5, 2);
                $this->range(9900000, 9999999, 3, 2);
                break;
            case '978-976':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 5999999, 2, 2);
                $this->range(6000000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-977':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 4999999, 3, 2);
                $this->range(5000000, 6999999, 4, 2);
                $this->range(7000000, 8499999, 3, 2);
                $this->range(8500000, 8999999, 5, 2);
                $this->range(9000000, 9999999, 2, 2);
                break;
            case '978-978':
                $this->range(0, 1999999, 3, 2);
                $this->range(2000000, 2999999, 4, 2);
                $this->range(3000000, 7999999, 5, 2);
                $this->range(8000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-979':
                $this->range(0, 999999, 3, 2);
                $this->range(1000000, 1499999, 4, 2);
                $this->range(1500000, 1999999, 5, 2);
                $this->range(2000000, 2999999, 2, 2);
                $this->range(3000000, 3999999, 4, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-980':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 5999999, 3, 2);
                $this->range(6000000, 9999999, 4, 2);
                break;
            case '978-981':
                $this->range(0, 1199999, 2, 2);
                $this->range(1200000, 1999999, 0, 2);
                $this->range(2000000, 2899999, 3, 2);
                $this->range(2900000, 2999999, 3, 2);
                $this->range(3000000, 3099999, 4, 2);
                $this->range(3100000, 3999999, 3, 2);
                $this->range(4000000, 9999999, 4, 2);
                break;
            case '978-982':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 2, 2);
                $this->range(9000000, 9799999, 4, 2);
                $this->range(9800000, 9999999, 5, 2);
                break;
            case '978-983':
                $this->range(0, 199999, 2, 2);
                $this->range(0200000, 1999999, 3, 2);
                $this->range(2000000, 3999999, 4, 2);
                $this->range(4000000, 4499999, 5, 2);
                $this->range(4500000, 4999999, 2, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 8999999, 3, 2);
                $this->range(9000000, 9899999, 4, 2);
                $this->range(9900000, 9999999, 5, 2);
                break;
            case '978-984':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-985':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 5999999, 3, 2);
                $this->range(6000000, 8999999, 4, 2);
                $this->range(9000000, 9999999, 5, 2);
                break;
            case '978-986':
                $this->range(0, 1199999, 2, 2);
                $this->range(1200000, 5599999, 3, 2);
                $this->range(5600000, 7999999, 4, 2);
                $this->range(8000000, 9999999, 5, 2);
                break;
            case '978-987':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 1999999, 4, 2);
                $this->range(2000000, 2999999, 5, 2);
                $this->range(3000000, 4999999, 2, 2);
                $this->range(5000000, 8999999, 3, 2);
                $this->range(9000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-988':
                $this->range(0, 1199999, 2, 2);
                $this->range(1200000, 1499999, 5, 2);
                $this->range(1500000, 1699999, 5, 2);
                $this->range(1700000, 1999999, 5, 2);
                $this->range(2000000, 7999999, 3, 2);
                $this->range(8000000, 9699999, 4, 2);
                $this->range(9700000, 9999999, 5, 2);
                break;
            case '978-989':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 5499999, 2, 2);
                $this->range(5500000, 7999999, 3, 2);
                $this->range(8000000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 5, 2);
                break;
            case '978-9927':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 3999999, 3, 2);
                $this->range(4000000, 4999999, 4, 2);
                $this->range(5000000, 9999999, 0, 2);
                break;
            case '978-9928':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 3999999, 3, 2);
                $this->range(4000000, 4999999, 4, 2);
                $this->range(5000000, 9999999, 0, 2);
                break;
            case '978-9929':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 5499999, 2, 2);
                $this->range(5500000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 4, 2);
                break;
            case '978-9930':
                $this->range(0, 4999999, 2, 2);
                $this->range(5000000, 9399999, 3, 2);
                $this->range(9400000, 9999999, 4, 2);
                break;
            case '978-9931':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9932':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8499999, 3, 2);
                $this->range(8500000, 9999999, 4, 2);
                break;
            case '978-9933':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9934':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 4999999, 2, 2);
                $this->range(5000000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 4, 2);
                break;
            case '978-9935':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9936':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 3999999, 2, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 4, 2);
                break;
            case '978-9937':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 4999999, 2, 2);
                $this->range(5000000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 4, 2);
                break;
            case '978-9938':
                $this->range(0, 7999999, 2, 2);
                $this->range(8000000, 9499999, 3, 2);
                $this->range(9500000, 9999999, 4, 2);
                break;
            case '978-9939':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9940':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 4999999, 2, 2);
                $this->range(5000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9941':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9942':
                $this->range(0, 8999999, 2, 2);
                $this->range(9000000, 9849999, 3, 2);
                $this->range(9850000, 9999999, 4, 2);
                break;
            case '978-9943':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 3999999, 3, 2);
                $this->range(4000000, 9999999, 4, 2);
                break;
            case '978-9944':
                $this->range(0, 999999, 4, 2);
                $this->range(1000000, 4999999, 3, 2);
                $this->range(5000000, 5999999, 4, 2);
                $this->range(6000000, 6999999, 2, 2);
                $this->range(7000000, 7999999, 3, 2);
                $this->range(8000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-9945':
                $this->range(0, 99999, 2, 2);
                $this->range(100000, 799999, 3, 2);
                $this->range(800000, 3999999, 2, 2);
                $this->range(4000000, 5699999, 3, 2);
                $this->range(5700000, 5799999, 2, 2);
                $this->range(5800000, 8499999, 3, 2);
                $this->range(8500000, 9999999, 4, 2);
                break;
            case '978-9946':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9947':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-9948':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8499999, 3, 2);
                $this->range(8500000, 9999999, 4, 2);
                break;
            case '978-9949':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9950':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 8499999, 3, 2);
                $this->range(8500000, 9999999, 4, 2);
                break;
            case '978-9951':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8499999, 3, 2);
                $this->range(8500000, 9999999, 4, 2);
                break;
            case '978-9952':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 3999999, 2, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 4, 2);
                break;
            case '978-9953':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 3999999, 2, 2);
                $this->range(4000000, 5999999, 3, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9954':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 3999999, 2, 2);
                $this->range(4000000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 4, 2);
                break;
            case '978-9955':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 9299999, 3, 2);
                $this->range(9300000, 9999999, 4, 2);
                break;
            case '978-9956':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9957':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 6999999, 3, 2);
                $this->range(7000000, 8499999, 2, 2);
                $this->range(8500000, 8799999, 4, 2);
                $this->range(8800000, 9999999, 2, 2);
                break;
            case '978-9958':
                $this->range(0, 399999, 2, 2);
                $this->range(400000, 899999, 3, 2);
                $this->range(900000, 999999, 4, 2);
                $this->range(1000000, 1899999, 2, 2);
                $this->range(1900000, 1999999, 4, 2);
                $this->range(2000000, 4999999, 2, 2);
                $this->range(5000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9959':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9499999, 3, 2);
                $this->range(9500000, 9699999, 4, 2);
                $this->range(9700000, 9799999, 3, 2);
                $this->range(9800000, 9999999, 2, 2);
                break;
            case '978-9960':
                $this->range(0, 5999999, 2, 2);
                $this->range(6000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9961':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 6999999, 2, 2);
                $this->range(7000000, 9499999, 3, 2);
                $this->range(9500000, 9999999, 4, 2);
                break;
            case '978-9962':
                $this->range(0, 5499999, 2, 2);
                $this->range(5500000, 5599999, 4, 2);
                $this->range(5600000, 5999999, 2, 2);
                $this->range(6000000, 8499999, 3, 2);
                $this->range(8500000, 9999999, 4, 2);
                break;
            case '978-9963':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 2499999, 2, 2);
                $this->range(2500000, 2799999, 3, 2);
                $this->range(2800000, 2999999, 4, 2);
                $this->range(3000000, 5499999, 2, 2);
                $this->range(5500000, 7349999, 3, 2);
                $this->range(7350000, 7499999, 4, 2);
                $this->range(7500000, 9999999, 4, 2);
                break;
            case '978-9964':
                $this->range(0, 6999999, 1, 2);
                $this->range(7000000, 9499999, 2, 2);
                $this->range(9500000, 9999999, 3, 2);
                break;
            case '978-9965':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9966':
                $this->range(0, 1499999, 3, 2);
                $this->range(1500000, 1999999, 4, 2);
                $this->range(2000000, 6999999, 2, 2);
                $this->range(7000000, 7499999, 4, 2);
                $this->range(7500000, 9599999, 3, 2);
                $this->range(9600000, 9999999, 4, 2);
                break;
            case '978-9967':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9968':
                $this->range(0, 4999999, 2, 2);
                $this->range(5000000, 9399999, 3, 2);
                $this->range(9400000, 9999999, 4, 2);
                break;
            case '978-9970':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9971':
                $this->range(0, 5999999, 1, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-9972':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 1999999, 1, 2);
                $this->range(2000000, 2499999, 3, 2);
                $this->range(2500000, 2999999, 4, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9973':
                $this->range(0, 599999, 2, 2);
                $this->range(600000, 899999, 3, 2);
                $this->range(900000, 999999, 4, 2);
                $this->range(1000000, 6999999, 2, 2);
                $this->range(7000000, 9699999, 3, 2);
                $this->range(9700000, 9999999, 4, 2);
                break;
            case '978-9974':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5499999, 2, 2);
                $this->range(5500000, 7499999, 3, 2);
                $this->range(7500000, 9499999, 4, 2);
                $this->range(9500000, 9999999, 2, 2);
                break;
            case '978-9975':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 3999999, 3, 2);
                $this->range(4000000, 4499999, 4, 2);
                $this->range(4500000, 8999999, 2, 2);
                $this->range(9000000, 9499999, 3, 2);
                $this->range(9500000, 9999999, 4, 2);
                break;
            case '978-9976':
                $this->range(0, 5999999, 1, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-9977':
                $this->range(0, 8999999, 2, 2);
                $this->range(9000000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-9978':
                $this->range(0, 2999999, 2, 2);
                $this->range(3000000, 3999999, 3, 2);
                $this->range(4000000, 9499999, 2, 2);
                $this->range(9500000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-9979':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 6499999, 2, 2);
                $this->range(6500000, 6599999, 3, 2);
                $this->range(6600000, 7599999, 2, 2);
                $this->range(7600000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9980':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 8999999, 2, 2);
                $this->range(9000000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-9981':
                $this->range(0, 999999, 2, 2);
                $this->range(1000000, 1599999, 3, 2);
                $this->range(1600000, 1999999, 4, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9499999, 3, 2);
                $this->range(9500000, 9999999, 4, 2);
                break;
            case '978-9982':
                $this->range(0, 7999999, 2, 2);
                $this->range(8000000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-9983':
                $this->range(0, 7999999, 0, 2);
                $this->range(8000000, 9499999, 2, 2);
                $this->range(9500000, 9899999, 3, 2);
                $this->range(9900000, 9999999, 4, 2);
                break;
            case '978-9984':
                $this->range(0, 4999999, 2, 2);
                $this->range(5000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9985':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 4, 2);
                break;
            case '978-9986':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8999999, 3, 2);
                $this->range(9000000, 9399999, 4, 2);
                $this->range(9400000, 9699999, 3, 2);
                $this->range(9700000, 9999999, 2, 2);
                break;
            case '978-9987':
                $this->range(0, 3999999, 2, 2);
                $this->range(4000000, 8799999, 3, 2);
                $this->range(8800000, 9999999, 4, 2);
                break;
            case '978-9988':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5499999, 2, 2);
                $this->range(5500000, 7499999, 3, 2);
                $this->range(7500000, 9999999, 4, 2);
                break;
            case '978-9989':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 1999999, 3, 2);
                $this->range(2000000, 2999999, 4, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 9499999, 3, 2);
                $this->range(9500000, 9999999, 4, 2);
                break;
            case '978-99901':
                $this->range(0, 4999999, 2, 2);
                $this->range(5000000, 7999999, 3, 2);
                $this->range(8000000, 9999999, 2, 2);
                break;
            case '978-99902':
                $this->range(0, 9999999, 0, 2);
                break;
            case '978-99903':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99904':
                $this->range(0, 5999999, 1, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99905':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99906':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 2, 2);
                $this->range(9000000, 9499999, 2, 2);
                $this->range(9500000, 9999999, 3, 2);
                break;
            case '978-99908':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99909':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 9499999, 2, 2);
                $this->range(9500000, 9999999, 3, 2);
                break;
            case '978-99910':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99911':
                $this->range(0, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99912':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 5999999, 3, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99913':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 3599999, 2, 2);
                $this->range(3600000, 5999999, 0, 2);
                $this->range(6000000, 6049999, 3, 2);
                $this->range(6050000, 9999999, 0, 2);
                break;
            case '978-99914':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99915':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99916':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 6999999, 2, 2);
                $this->range(7000000, 9999999, 3, 2);
                break;
            case '978-99917':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99918':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99919':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 3999999, 3, 2);
                $this->range(4000000, 6999999, 2, 2);
                $this->range(7000000, 7999999, 2, 2);
                $this->range(8000000, 8499999, 3, 2);
                $this->range(8500000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99920':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99921':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 6999999, 2, 2);
                $this->range(7000000, 7999999, 3, 2);
                $this->range(8000000, 8999999, 1, 2);
                $this->range(9000000, 9999999, 2, 2);
                break;
            case '978-99922':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 6999999, 2, 2);
                $this->range(7000000, 9999999, 3, 2);
                break;
            case '978-99923':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99924':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99925':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99926':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 5999999, 2, 2);
                $this->range(6000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 2, 2);
                break;
            case '978-99927':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99928':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99929':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99930':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99931':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99932':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 5999999, 2, 2);
                $this->range(6000000, 6999999, 3, 2);
                $this->range(7000000, 7999999, 1, 2);
                $this->range(8000000, 9999999, 2, 2);
                break;
            case '978-99933':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99934':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99935':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 1, 2);
                $this->range(9000000, 9999999, 2, 2);
                break;
            case '978-99936':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99937':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99938':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 5999999, 2, 2);
                $this->range(6000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 2, 2);
                break;
            case '978-99939':
                $this->range(0, 5999999, 1, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99940':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 6999999, 2, 2);
                $this->range(7000000, 9999999, 3, 2);
                break;
            case '978-99941':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99942':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99943':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99944':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99945':
                $this->range(0, 5999999, 1, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99946':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99947':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 6999999, 2, 2);
                $this->range(7000000, 9599999, 3, 2);
                $this->range(9600000, 9999999, 2, 2);
                break;
            case '978-99948':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99949':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99950':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99951':
                $this->range(0, 9999999, 0, 2);
                break;
            case '978-99952':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99953':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 7999999, 2, 2);
                $this->range(8000000, 9399999, 3, 2);
                $this->range(9400000, 9999999, 2, 2);
                break;
            case '978-99954':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 6999999, 2, 2);
                $this->range(7000000, 8799999, 3, 2);
                $this->range(8800000, 9999999, 2, 2);
                break;
            case '978-99955':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 1999999, 2, 2);
                $this->range(2000000, 5999999, 2, 2);
                $this->range(6000000, 7999999, 3, 2);
                $this->range(8000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 2, 2);
                break;
            case '978-99956':
                $this->range(0, 5999999, 2, 2);
                $this->range(6000000, 8599999, 3, 2);
                $this->range(8600000, 9999999, 2, 2);
                break;
            case '978-99957':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99958':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 9499999, 2, 2);
                $this->range(9500000, 9999999, 3, 2);
                break;
            case '978-99959':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 5999999, 2, 2);
                $this->range(6000000, 9999999, 3, 2);
                break;
            case '978-99960':
                $this->range(0, 999999, 1, 2);
                $this->range(1000000, 9499999, 2, 2);
                $this->range(9500000, 9999999, 3, 2);
                break;
            case '978-99961':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99962':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99963':
                $this->range(0, 4999999, 2, 2);
                $this->range(5000000, 9999999, 3, 2);
                break;
            case '978-99964':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99965':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99966':
                $this->range(0, 2999999, 1, 2);
                $this->range(3000000, 6999999, 2, 2);
                $this->range(7000000, 7999999, 3, 2);
                $this->range(8000000, 8999999, 0, 2);
                $this->range(9000000, 9999999, 0, 2);
                break;
            case '978-99967':
                $this->range(0, 1999999, 1, 2);
                $this->range(2000000, 5999999, 2, 2);
                $this->range(6000000, 8999999, 3, 2);
                $this->range(9000000, 9999999, 0, 2);
                break;
            case '978-99968':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 5999999, 3, 2);
                $this->range(6000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99969':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '978-99970':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99971':
                $this->range(0, 5999999, 1, 2);
                $this->range(6000000, 8499999, 2, 2);
                $this->range(8500000, 9999999, 3, 2);
                break;
            case '978-99972':
                $this->range(0, 4999999, 1, 2);
                $this->range(5000000, 8999999, 2, 2);
                $this->range(9000000, 9999999, 3, 2);
                break;
            case '978-99973':
                $this->range(0, 3999999, 1, 2);
                $this->range(4000000, 7999999, 2, 2);
                $this->range(8000000, 9999999, 3, 2);
                break;
            case '979-10':
                $this->range(0, 1999999, 2, 2);
                $this->range(2000000, 6999999, 3, 2);
                $this->range(7000000, 8999999, 4, 2);
                $this->range(9000000, 9759999, 5, 2);
                $this->range(9760000, 9999999, 6, 2);
                break;
            case '979-11':
                $this->range(0, 2499999, 2, 2);
                $this->range(2500000, 5499999, 3, 2);
                $this->range(5500000, 8499999, 4, 2);
                $this->range(8500000, 9499999, 5, 2);
                $this->range(9500000, 9999999, 6, 2);
                break;
        }
    }

    /**
     * Get Publication Element
    */
    private function getPublicationElement()
    {
        $this->isbnSplit[3] = substr($this->isbn, $this->parsed(), -1);
    }

    /**
     * Get Check Digit
    */
    private function getCheckDigit()
    {
        $this->isbnSplit[4] = substr($this->isbn, -1);
    }
}

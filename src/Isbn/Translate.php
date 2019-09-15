<?php
/**
 * Check Digit.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author linkkingjay <linkingjay@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */

namespace Isbn;

/**
 * Translate.
 */
class Translate
{
    /**
     * Check Digit Instance.
     *
     * @var CheckDigit
     */
    private $checkDigit;

    /**
     * Constructor.
     *
     * @param CheckDigit $checkDigit
     */
    public function __construct(CheckDigit $checkDigit)
    {
        $this->checkDigit = $checkDigit;
    }

    /**
     * Convert $isbn to ISBN-10.
     *
     * @param string $isbn
     *
     * @throws Exception
     *
     * @return string
     */
    public function to10($isbn)
    {
        if (\is_string($isbn) === false) {
            throw new Exception('Invalid parameter type.');
        }

        if (\strlen($isbn) > 13) {
            $isbn = \substr($isbn, 4, -1);
        } else {
            $isbn = \substr($isbn, 3, -1);
        }

        return $isbn . $this->checkDigit->make($isbn);
    }

    /**
     * Convert $isbn to ISBN-13.
     *
     * @param string $isbn
     *
     * @throws Exception
     *
     * @return string
     */
    public function to13($isbn)
    {
        if (\is_string($isbn) === false) {
            throw new Exception('Invalid parameter type.');
        }

        $isbn = \substr($isbn, 0, -1);

        if (\strlen($isbn) > 9) {
            $isbn = '978-' . $isbn;
        } else {
            $isbn = '978' . $isbn;
        }

        return $isbn . $this->checkDigit->make($isbn);
    }
}

<?php
/**
 * Validation.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */

namespace Isbn;

/**
 * Validation.
 */
class Validation
{
    /**
     * Check Instance.
     *
     * @var Check
     */
    private $check;

    /**
     * Hyphens Instance.
     *
     * @var Hyphens
     */
    private $hyphens;

    /**
     * Constructor.
     *
     * @param Check   $check
     * @param Hyphens $hyphens
     */
    public function __construct(Check $check, Hyphens $hyphens)
    {
        $this->check   = $check;
        $this->hyphens = $hyphens;
    }

    /**
     * Validate the ISBN $isbn.
     *
     * @param string $isbn
     *
     * @return bool
     */
    public function isbn($isbn)
    {
        if ($this->check->is13($isbn)) {
            return $this->isbn13($isbn);
        }
        if ($this->check->is10($isbn)) {
            return $this->isbn10($isbn);
        }

        return false;
    }

    /**
     * Validate the ISBN-10 $isbn.
     *
     * @param string $isbn
     *
     * @throws Exception
     *
     * @return bool
     */
    public function isbn10($isbn)
    {
        if (\is_string($isbn) === false) {
            throw new Exception('Invalid parameter type.');
        }

        //Verify ISBN-10 scheme
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (\strlen($isbn) != 10) {
            return false;
        }
        if (\preg_match('/\d{9}[0-9xX]/i', $isbn) == false) {
            return false;
        }

        //Verify checksum
        $check = 0;
        for ($i = 0; $i < 10; $i++) {
            if (\strtoupper($isbn[$i]) === 'X') {
                $check += 10 * \intval(10 - $i);
            } else {
                $check += \intval($isbn[$i]) * \intval(10 - $i);
            }
        }

        return $check % 11 === 0;
    }

    /**
     * Validate the ISBN-13 $isbn.
     *
     * @param string $isbn
     *
     * @throws Exception
     *
     * @return bool
     */
    public function isbn13($isbn)
    {
        if (\is_string($isbn) === false) {
            throw new Exception('Invalid parameter type.');
        }

        //Verify ISBN-13 scheme
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (\strlen($isbn) != 13) {
            return false;
        }
        if (\preg_match('/\d{13}/i', $isbn) == false) {
            return false;
        }

        //Verify checksum
        $check = 0;
        for ($i = 0; $i < 13; $i += 2) {
            $check += \substr($isbn, $i, 1);
        }
        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * \substr($isbn, $i, 1);
        }

        return $check % 10 === 0;
    }
}

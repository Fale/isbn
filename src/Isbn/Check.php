<?php
/**
 * Check.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */

namespace Isbn;

/**
 * Check.
 */
class Check
{
    /**
     * Hyphens.
     *
     * @var Hyphens
     */
    private $hyphens;

    /**
     * Constructor.
     *
     * @param Hyphens $hyphens
     */
    public function __construct(Hyphens $hyphens)
    {
        $this->hyphens = $hyphens;
    }

    /**
     * Identifies the ISBN format and returns the corresponding
     * number or false if no pattern matches.
     *
     * @param string
     *
     * @return int|false
     */
    public function identify($isbn)
    {
        if ($this->is10($isbn) === true) {
            return 10;
        }

        return $this->is13($isbn) === true ? 13 : false;
    }

    /**
     * Checks whether $isbn matches the ISBN-10 format.
     *
     * @param string $isbn
     *
     * @throws Exception
     *
     * @return bool
     */
    public function is10($isbn)
    {
        if (\is_string($isbn) === false) {
            throw new Exception('Invalid parameter type.');
        }

        $isbn = $this->hyphens->removeHyphens($isbn);

        return \strlen($isbn) === 10;
    }

    /**
     * Checks whether $isbn matches the ISBN-13 format.
     *
     * @param string $isbn
     *
     * @throws Exception
     *
     * @return bool
     */
    public function is13($isbn)
    {
        if (\is_string($isbn) === false) {
            throw new Exception('Invalid parameter type.');
        }

        $isbn = $this->hyphens->removeHyphens($isbn);

        return \strlen($isbn) === 13;
    }
}

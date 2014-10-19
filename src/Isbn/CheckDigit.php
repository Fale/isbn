<?php
/**
 * Check Digit
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author linkkingjay <linkingjay@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 * @version 2.0.0
 * @package ISBN
*/
namespace Isbn;

/**
 * Check Digit
*/
class CheckDigit
{
    /**
     * Hyphens
    */
    private $hyphens;
    
    /**
     * Constructor
     *
     * @param Hyphens $hyphens
    */
    public function __construct(Hyphens $hyphens)
    {
        $this->hyphens = $hyphens;
    }

    /**
     * Calculate the check digit of $isbn.
     *
     * @param string $isbn
     * @return boolean|string|int
    */
    public function make($isbn)
    {
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (strlen($isbn) === 12 or strlen($isbn) === 13) {
            return $this->make13($isbn);
        } elseif (strlen($isbn) === 9 or strlen($isbn) === 10) {
            return $this->make10($isbn);
        }
        
        return false;
    }

    /**
     * Calculate the check digit of the ISBN-10 $isbn.
     *
     * @param string $isbn
     * @return boolean|string|int
    */
    public function make10($isbn)
    {
        //Verify length
        $isbnLength = strlen($isbn);
        if ($isbnLength < 9 or $isbnLength > 10) {
            return false;
        }

        //Calculate check digit
        $check = 0;
        for ($i = 0; $i < 9; $i++) {
            if ($isbn[$i] === "X") {
                $check += 10 * intval(10 - $i);
            } else {
                $check += intval($isbn[$i]) * intval(10 - $i);
            }
        }

        $check = 11 - $check % 11;
        if ($check === 10) {
            return 'X';
        } elseif ($check === 11) {
            return 0;
        }
        
        return $check;
    }

    /**
     * Calculate the check digit of the ISBN-13 $isbn
     *
     * @param string $isbn
     * @return boolean|int
    */
    public function make13($isbn)
    {
        //Verify length
        $isbnLength = strlen($isbn);
        if ($isbnLength < 12 or $isbnLength > 13) {
            return false;
        }

        //Calculate check digit
        $check = 0;
        for ($i = 0; $i < 12; $i += 2) {
            $check += substr($isbn, $i, 1);
        }

        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * substr($isbn, $i, 1);
        }

        $check = 10 - $check % 10;
        if ($check === 10) {
            return 0;
        }
    
        return $check;
    }
}

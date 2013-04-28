<?php

namespace Isbn;

class Check {

    public static function isbn($isbn)
    {
        if (strlen($isbn) == 13)
            return Check::isbn13($isbn);
        if (strlen($isbn) == 10)
            return Check::isbn10($isbn);
        return false;
    }

    public static function isbn10($isbn)
    {
        if (strlen($isbn) != 10)
            return false;
        $check = 0;
        for ($i = 0; $i < 10; $i++)
            if ($isbn[$i] == "X")
                $check += 10 * intval(10 - $i);
            else
                $check += intval($isbn[$i]) * intval(10 - $i);
        return $check % 11 == 0;
    }

    public static function isbn13($isbn)
    {
        if (strlen($isbn) != 13)
            return false;
        $check = 0;
        for ($i = 0; $i < 13; $i+=2)
            $check += substr($isbn, $i, 1);
        for ($i = 1; $i < 12; $i+=2)
            $check += 3 * substr($isbn, $i, 1);
        return $check % 10 == 0;
    }
}

<?php

namespace Isbn;

class Check {

    public static function identify($isbn)
    {
        if (Check::is10($isbn))
            return 10;
        if (Check::is13($isbn))
            return 13;
        return false;
    }

    public static function is10($isbn)
    {
        $isbn = Hyphens::removeHyphens($isbn);
        if (strlen($isbn) == 10)
            return true;
        return false;
    }

    public static function is13($isbn)
    {
        $isbn = Hyphens::removeHyphens($isbn);
        if (strlen($isbn) == 13)
            return true;
        return false;
    }

}

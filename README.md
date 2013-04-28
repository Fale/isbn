# ISBN PHP library #
This library is develop to give all ISBN (both ISBN-10 and ISBN-13) related tools needed by PHP developers.

## ISBN Validation ##
This class allows you to validate ISBN-10 and ISBN-13 codes.
Examples:

    Isbn\Validation::isbn('8881837188'); // Will return true
    Isbn\Validation::isbn('8881837187'); // Will return false
    Isbn\Validation::isbn('9788889527191'); // Will return true
    Isbn\Validation::isbn('9788889527190'); // Will return false
    Isbn\Validation::isbn10('8881837188'); // Will return true
    Isbn\Validation::isbn10('8881837187'); // Will return false
    Isbn\Validation::isbn13('9788889527191'); // Will return true
    Isbn\Validation::isbn13('9788889527190'); // Will return false

## ISBN Hyphens ##
This class provides simple functions to work with hyphens.

### Remove Hyphens ###
This function allows you to remove hyphens from the ISBN-10 and ISBN-13.
Examples:

    Isbn\Hyphens::removeHyphens('85 359 0277 5'); // Will return 8535902775
    Isbn\Hyphens::removeHyphens('0-943396-04-2'); // Will return 0943396042
    Isbn\Hyphens::removeHyphens('978 988 00 3827 3'); // Will return 9789880038273
    Isbn\Hyphens::removeHyphens('979-10-90636-07-1'); // Will return 9791090636071

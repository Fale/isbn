# ISBN PHP library [![Build Status](https://travis-ci.org/Fale/isbn.png?branch=master)](https://travis-ci.org/Fale/isbn) #
This library is developed to provide all tools needed to handle ISBN (both ISBN-10 and ISBN-13) codes to PHP developers.

## IMPORTANT NOTICE ##
`dev-master` could be pretty different from the **3.x** version. If you want to stay with version **3.x**, please use `3.0.0` or `3.0.x-dev` or `3.x-dev`.

## IMPORTANT NOTICE NUMBER 2 ##
ISBN ranges change every so often. Data are right as of Wed, 15 Nov 2017 13:30:29 CET.

## Initialization ##
```php
$isbn = new Isbn\Isbn();
```

## Check ##
This function allows you to verify if an ISBN code is an ISBN-10 or ISBN-13. This does not verifies if the ISBN code is valid. To check if the ISBN code is valid, you can use the `Validation` class.
Examples:

```php
$isbn->check->is10('888183718'); // Will return false
$isbn->check->is13('9788889527191'); // Will return true
$isbn->check->is13('978888952719'); // Will return false
$isbn->check->identify('8881837188'); // Will return 10
$isbn->check->identify('888183718'); // Will return false
$isbn->check->identify('9788889527191'); // Will return 13
$isbn->check->identify('978888952719'); // Will return false
```

## Validation ##
This class allows you to validate ISBN-10 and ISBN-13.
Examples:

```php
$isbn->validation->isbn('8881837188'); // Will return true
$isbn->validation->isbn('8881837187'); // Will return false
$isbn->validation->isbn('9788889527191'); // Will return true
$isbn->validation->isbn('9788889527190'); // Will return false
$isbn->validation->isbn10('8881837188'); // Will return true
$isbn->validation->isbn10('8881837187'); // Will return false
$isbn->validation->isbn13('9788889527191'); // Will return true
$isbn->validation->isbn13('9788889527190'); // Will return false
```

## Hyphens ##
This class provides simple functions to work with hyphens.

### Add Hyphens ###
This function allows you to put correct hyphens in ISBN-10 and ISBN-13.
Examples:

```php
echo $isbn->hyphens->addHyphens('9791090636071'); // Will return 979-10-90636-07-1

echo $hyphens->addHyphens('9791090636071', ' '); // Will return 979 10 90636 07 1
```

### Remove Hyphens ###
This function allows you to remove hyphens from the ISBN-10 and ISBN-13.
Examples:

```php
$isbn->hyphens->removeHyphens('85 359 0277 5'); // Will return 8535902775
$isbn->hyphens->removeHyphens('0-943396-04-2'); // Will return 0943396042
$isbn->hyphens->removeHyphens('978 988 00 3827 3'); // Will return 9789880038273
$isbn->hyphens->removeHyphens('979-10-90636-07-1'); // Will return 9791090636071
```

### Fix Hyphens ###
This function allows you to fix hyphens in ISBN-10 and ISBN-13

```php
$isbn->hyphens->fixHyphens('85 35902 77 5', ' '); // Will return 85 359 0277 5
$isbn->hyphens->fixHyphens('0 943 3960 42'); // Will return 0-943396-04-2
$isbn->hyphens->fixHyphens('978 988 003827 3', ' '); // Will return 978 988 00 3827 3
$isbn->hyphens->fixHyphens('979-10906-36-07-1'); // Will return 979-10-90636-07-1
```

## CheckDigit ##
This class allows you to calculate the check digit for ISBN-10 and ISBN-13.
Examples:

```php
$isbn->checkDigit->make('888183718'); // Will return 8
$isbn->checkDigit->make('978888952719'); // Will return 1
$isbn->checkDigit->make10('888183718'); // Will return 8
$isbn->checkDigit->make13('978888952719'); // Will return 1
```

## Translate ##
This class allows you to convert ISBN-10 to ISBN-13 and back.
Examples:

```php
$isbn->translate->to13('8889527191'); // Will return 9788889527191
$isbn->translate->to10('9786028328227'); // Will return 6028328227
```

# Develop this library #
If you are interested in some new features please open a bug on GitHub. If you already have a patch available, please, open a pull request. Before opening a pull request, be sure that all tests are passed.

## Generation ##

* Get the `RangeMessage.xml` file from https://www.isbn-international.org/range_file_generation
* `cp import/RegistrantElement.php /tmp`
* `cp RangeMessage.xml /tmp`
* `podman run --rm -it --volume /tmp:/tmp php sh -c "cd /tmp && php RegistrantElement.php" > /tmp/out`

## Tests ##
To check the tests run the following:

```sh
vendor/bin/phpunit tests
```

from the project root folder.
If the folder `vendor` is empty or non-existing, run `composer install` or `composer.phar install` depending on your `composer` installation.

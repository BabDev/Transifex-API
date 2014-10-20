Transifex API Package [![Build Status](https://travis-ci.org/BabDev/Transifex-API.png?branch=master)](https://travis-ci.org/BabDev/Transifex-API) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/BabDev/Transifex-API/badges/quality-score.png?s=a338a281b006a93fb17c69a83ec8a239e9ed7e74)](https://scrutinizer-ci.com/g/BabDev/Transifex-API/) [![Code Coverage](https://scrutinizer-ci.com/g/BabDev/Transifex-API/badges/coverage.png?s=513f6de839a37e22865d8d688c60fbe35695cbb2)](https://scrutinizer-ci.com/g/BabDev/Transifex-API/)
===============

The *Transifex API Package* wrapping the Transifex API for easy use.

Using the Package
------------
The namespaced version of the library is PSR-4 compliant and can be included in your projects using Composer.  Installation instructions can be [found below](#installation-via-git).

Requirements
------------

* Production
    * Joomla Framework [HTTP](https://github.com/joomla-framework/http) package
    * PHP 5.3.10 or later
* Development
    * Joomla Framework [Test](https://github.com/joomla-framework-test) package
    * [PHPUnit](http://phpunit.de/)
    * [PHP_CodeSniffer](http://www.squizlabs.com/php-codesniffer)

Installation
------------

## Installation via GIT

Get the source code from GIT:

```sh
git clone git://github.com/BabDev/Transifex-API.git
```

## Installation via Composer

Add `"babdev/transifex": "~1.0"` to the require block in your composer.json and then run `composer install`.

```json
{
	"require": {
		"babdev/transifex": "~1.0"
	},
}
```

Alternatively, you can simply run the following from the command line:

```sh
composer require babdev/transifex "~1.0"
```

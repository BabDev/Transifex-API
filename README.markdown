BabDev Library [![Build Status](https://travis-ci.org/BabDev/BabDev-Library.png?branch=master)](https://travis-ci.org/BabDev/BabDev-Library) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/BabDev/BabDev-Library/badges/quality-score.png?s=a338a281b006a93fb17c69a83ec8a239e9ed7e74)](https://scrutinizer-ci.com/g/BabDev/BabDev-Library/) [![Code Coverage](https://scrutinizer-ci.com/g/BabDev/BabDev-Library/badges/coverage.png?s=513f6de839a37e22865d8d688c60fbe35695cbb2)](https://scrutinizer-ci.com/g/BabDev/BabDev-Library/)
===============

The *BabDev Library* is an collection of classes for general use in PHP based applications.  Originally inspired as libraries extending the Joomla! Platform, the library has evolved to be more suited for general use in PHP applications while still aiming to support Joomla developers.

Using the Library
------------
The namespaced version of the library is PSR-4 compliant and can be included in your projects using Composer.  Installation instructions can be [found below](#installation-via-git).

The library can be autoloaded in the Joomla CMS starting in version 3.2 with the following code:

```php
JLoader::registerNamespace('BabDev', '/path/to/src/BabDev');
```

Library Contents
------------
The *BabDev Library* is composed of the following classes and packages:

- [\BabDev\Transifex](/src/BabDev/Transifex) - The `Transifex` package is a PHP wrapper implementing the [Transifex API](http://support.transifex.com/customer/portal/topics/440186-api/articles)

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
git clone git://github.com/BabDev/BabDev-Library.git
```

## Installation via Composer

Add `"babdev/library": "dev-master"` to the require block in your composer.json, make sure you have `"minimum-stability": "dev"` and then run `composer install`.

```json
{
	"require": {
		"babdev/library": "dev-master"
	},
	"minimum-stability": "dev"
}
```

Alternatively, you can simply run the following from the command line:

```sh
composer init --stability="dev"
composer require babdev/library "dev-master"
```

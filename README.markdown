BabDev Library [![Build Status](https://travis-ci.org/mbabker/BabDev-Libraries.png?branch=master)](https://travis-ci.org/mbabker/BabDev-Libraries)
===============

The *BabDev Library* is an collection of libraries for general use inspired by the Joomla! Framework.  Together with the Joomla! Framework, the BabDev Library can be used to develop applications
using PHP and can be leveraged by the Joomla! CMS to create advanced extensions.


Using the Library
------------
The namespaced version of the library is PSR-0 compliant and can be included in your projects using Composer.

To introduce the library into the Joomla! CMS, you will need to add the following line, only available in 3.2 or later:

```php
JLoader::registerNamespace('BabDev', '/path/to/src/BabDev');
```

Requirements
------------

* Joomla Framework Registry and URI packages
* PHP 5.3.10 or later


Installation
------------

## Installation via GIT

Get the source code from GIT:

```sh
git clone git://github.com/mbabker/BabDev-Libraries.git
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

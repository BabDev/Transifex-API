## Overview

The Transifex API package provides a PHP interface for interacting with the [Transifex API](http://docs.transifex.com/api/).

### Basic Use

The primary interface for interacting with the Transifex package is the [Transifex](classes/Transifex.md) class. This class serves as a factory object of sorts and allows developers to manage the options used by the API objects and HTTP connector as well as retrieve instances of the API objects. To create a `Transifex` object, you only need to instantiate it.

```php
use BabDev\Transifex\Transifex;

$transifex = new Transifex;
```

The constructor takes two optional arguments which are documented on the [class documentation](classes/Transifex.md) page.

Once instantiated, the options which are used by the API objects can be managed through the `getOption()` and `setOption()` methods. For example, to define a custom namespace to locate API connector objects, you could use the following code:

```php
use BabDev\Transifex\Transifex;

$transifex = new Transifex;

$transifex->setOption('object.namespace', 'My\Custom\Transifex');

// $namespace = 'My\Custom\Transifex'
$namespace = $transifex->getOption('object.namespace');
```

To retrieve an instance of an API object, you would use the `get()` method. API objects are named based on the documented sections of the Transifex API. To retrieve an object that can interface with the "formats" API section, you would use the following code:

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Formats $formats */
$formats = (new Transifex)->get('formats');
```

The `get()` method optionally supports locating objects in a custom namespace to enable developers to add custom connectors or extend the base API classes. This behavior is documented in the [class documentation](classes/Transifex.md) page.

### API Responses

This package utilizes [PSR-7 compatible](http://www.php-fig.org/psr/psr-7/) requests and responses by way of the [Guzzle]((https://github.com/guzzle/guzzle)) HTTP client. For all API requests, a [`ResponseInterface`](http://www.php-fig.org/psr/psr-7/#3-3-psr-http-message-responseinterface) compatible object will be returned on a successful request.

This package is not catching Exceptions thrown by the HTTP client so users implementing this package should implement appropriate error handling mechanisms.

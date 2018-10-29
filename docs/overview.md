## Overview

The Transifex API package provides a PHP interface for interacting with the [Transifex API](http://docs.transifex.com/api/).

### Basic Use

The primary interface for interacting with the Transifex package is the [Transifex](classes/Transifex.md) class. This class serves as a factory object of sorts and allows developers to manage the options used by the API objects and HTTP connector as well as retrieve instances of the API objects. To create a `Transifex` object, you only need to instantiate it with the appropriate dependencies ([PSR-17 factories](https://www.php-fig.org/psr/psr-17/) and a [PSR-18 HTTP client](https://www.php-fig.org/psr/psr-18/)).

```php
use BabDev\Transifex\Transifex;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

$client = // new ClientInterface(); (any PSR-18 HTTP client)
$requestFactory = // new RequestFactoryInterface(); (any PSR-17 Request factory)
$streamFactory = // new StreamFactoryInterface(); (any PSR-17 Stream factory)
$uriFactory = // new UriFactoryInterface(); (any PSR-17 URI factory)

$transifex = new Transifex($client, $requestFactory, $streamFactory, $uriFactory);
```

The constructor takes one optional argument which is documented on the [class documentation](classes/Transifex.md) page.

Once instantiated, the options which are used by the API objects can be managed through the `getOption()` and `setOption()` methods. For example, to define a custom namespace to locate API connector objects, you could use the following code:

```php
$transifex->setOption('object.namespace', 'My\Custom\Transifex');

// $namespace = 'My\Custom\Transifex'
$namespace = $transifex->getOption('object.namespace');
```

To retrieve an instance of an API object, you would use the `get()` method. API objects are named based on the documented sections of the Transifex API. To retrieve an object that can interface with the "formats" API section, you would use the following code:

```php
/** @var \BabDev\Transifex\Formats $formats */
$formats = $transifex->get('formats');
```

The `get()` method optionally supports locating objects in a custom namespace to enable developers to add custom connectors or extend the base API classes. This behavior is documented in the [class documentation](classes/Transifex.md) page.

### API Responses

This package returns a [PSR-7 compatible](https://www.php-fig.org/psr/psr-7/) response created by the underlying [PSR-18 HTTP client](https://www.php-fig.org/psr/psr-18/).

This package is not catching Exceptions thrown by the HTTP client so users implementing this package should implement appropriate error handling mechanisms.

## ApiFactory

The `ApiFactory` class is the default [`FactoryInterface`](FactoryInterface.md) implementation responsible for creating instances of the API connector classes included in this package.

### Instantiating the factory

To create a `ApiFactory` object, you need to instantiate it with the appropriate dependencies ([PSR-17 factories](https://www.php-fig.org/psr/psr-17/) and a [PSR-18 HTTP client](https://www.php-fig.org/psr/psr-18/)).

```php
use BabDev\Transifex\ApiFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

$client = // new ClientInterface(); (any PSR-18 HTTP client)
$requestFactory = // new RequestFactoryInterface(); (any PSR-17 Request factory)
$streamFactory = // new StreamFactoryInterface(); (any PSR-17 Stream factory)
$uriFactory = // new UriFactoryInterface(); (any PSR-17 URI factory)

$apiFactory = new ApiFactory($client, $requestFactory, $streamFactory, $uriFactory);
```

### Retrieving an API connector class

The factory is responsible for creating an [`ApiConnector`](ApiConnector.md) instance to communicate with the selected API segment.

```php
/** @var \BabDev\Transifex\Connector\Translations $connector */
$connector = $apiFactory->createApiConnector('translations');
```

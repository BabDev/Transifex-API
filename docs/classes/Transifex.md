## Transifex

The `Transifex` class is the package's primary interface and serves as the API factory and allows developers to manage the options used by the API objects and HTTP connector as well as retrieve instances of the API objects.

### Instantiating Transifex

The `Transifex` object should be instantiated directly. The class has one required argument and one optional argument.

#### Required Arguments

- A `BabDev\Transifex\FactoryInterface` implementation

#### Example 1: Basic Instantiation

```php
use BabDev\Transifex\ApiFactory;
use BabDev\Transifex\Transifex;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/*
 * PSR-17 and PSR-18 dependencies necessary to create the ApiFactory
 */

$client = // new ClientInterface(); (any PSR-18 HTTP client)
$requestFactory = // new RequestFactoryInterface(); (any PSR-17 Request factory)
$streamFactory = // new StreamFactoryInterface(); (any PSR-17 Stream factory)
$uriFactory = // new UriFactoryInterface(); (any PSR-17 URI factory)

$apiFactory = new ApiFactory($client, $requestFactory, $streamFactory, $uriFactory)
$transifex = new Transifex($apiFactory);
```

#### Example 2: Injection of an Options Array

```php
use BabDev\Transifex\ApiFactory;
use BabDev\Transifex\Transifex;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/*
 * PSR-17 and PSR-18 dependencies necessary to create the ApiFactory
 */

$client = // new ClientInterface(); (any PSR-18 HTTP client)
$requestFactory = // new RequestFactoryInterface(); (any PSR-17 Request factory)
$streamFactory = // new StreamFactoryInterface(); (any PSR-17 Stream factory)
$uriFactory = // new UriFactoryInterface(); (any PSR-17 URI factory)

$apiFactory = new ApiFactory($client, $requestFactory, $streamFactory, $uriFactory)

// Build our options array setting our API credentials to authenticate
$options = [
	'api.username' => 'MyUsername',
	'api.password' => 'MyPassword'
];

$transifex = new Transifex($apiFactory, $options);
```

### Supported Options

Below is a list of options that are supported in the `Transifex` object and API class objects; these may be set by injecting an options array when instantiating the `Transifex` object or using the `getOption()` method.

- 'api.username' - The username of the user account you are using to authenticate to the Transifex API
- 'api.password' - The password of the user account you are using to authenticate to the Transifex API
- 'base_uri' - The base API URL for connecting to the Transifex API, this typically should remain unchanged

### Retrieving a ApiConnector instance

All API connectors extend the base `ApiConnector` class. API objects are named based on their grouping in the Transifex API documentation. To retrieve an object connecting to the "formats" API endpoints, simply execute this code:

```php
/** @var \BabDev\Transifex\Connector\Formats $formats */
$formats = $transifex->get('formats');
```

The `get()` method requires one parameter, the object name, and this should be a lower-cased string with no spaces. For API endpoints such as "Language info", you would retrieve this API object by calling `$transifex->get('languageinfo')`. A new object is instantiated with each call to the `get()` method.

```php
use BabDev\Transifex\ApiFactory;
use BabDev\Transifex\Transifex;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/*
 * PSR-17 and PSR-18 dependencies necessary to create the ApiFactory
 */

$client = // new ClientInterface(); (any PSR-18 HTTP client)
$requestFactory = // new RequestFactoryInterface(); (any PSR-17 Request factory)
$streamFactory = // new StreamFactoryInterface(); (any PSR-17 Stream factory)
$uriFactory = // new UriFactoryInterface(); (any PSR-17 URI factory)

$apiFactory = new ApiFactory($client, $requestFactory, $streamFactory, $uriFactory)
$transifex = new Transifex($apiFactory);

/** @var \BabDev\Transifex\Connector\Formats $formats */
$formats = $transifex->get('formats');
```

### Managing Object Options

The options for the `Transifex` object and API objects can be managed through the `getOption()` and `setOption()` methods.

#### `getOption()`

The `getOption()` method returns the current value of the requested option. It has one required parameter, the option name to retrieve, and an optional second argument which sets a default value if an option is not set.

#### `setOption()`

The `setOption()` method sets an option value to the internal object store. It has two required parameters; the option name to set and the value of the option.

#### API Use

The following example demonstrates use of the option API methods.

```php
use BabDev\Transifex\ApiFactory;
use BabDev\Transifex\Transifex;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/*
 * PSR-17 and PSR-18 dependencies necessary to create the ApiFactory
 */

$client = // new ClientInterface(); (any PSR-18 HTTP client)
$requestFactory = // new RequestFactoryInterface(); (any PSR-17 Request factory)
$streamFactory = // new StreamFactoryInterface(); (any PSR-17 Stream factory)
$uriFactory = // new UriFactoryInterface(); (any PSR-17 URI factory)

$apiFactory = new ApiFactory($client, $requestFactory, $streamFactory, $uriFactory)

// Build our options array setting our API credentials to authenticate
$options = [
	'api.username' => 'MyUsername',
	'api.password' => 'MyPassword'
];

$transifex = new Transifex($apiFactory, $options);

// $bar = null since our option is not set
$bar = $transifex->getOption('foo');

// $bar = 'goo' since we have supplied a default value for our non-set option
$bar = $transifex->getOption('foo', 'goo');
```

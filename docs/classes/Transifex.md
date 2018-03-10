## Transifex

The `Transifex` class is the package's primary interface and serves as a factory object of sorts and allows developers to manage the options used by the API objects and HTTP connector as well as retrieve instances of the API objects.

### Instantiating Transifex

The `Transifex` object should be instantiated directly and optionally supports two arguments; an options array and a `GuzzleHttp\ClientInterface` instance.

#### Example 1: Basic Instantiation

```php
use BabDev\Transifex\Transifex;

$transifex = new Transifex;
```

#### Example 2: Injection of an Options Array and HTTP object

```php
use BabDev\Transifex\Transifex;
use GuzzleHttp\Client;

// Build our HTTP connector using our already retrieved driver and passing an empty options array in
$http = new Client();

// Build our options array setting our API credentials to authenticate
$options = [
	'api.username' => 'MyUsername',
	'api.password' => 'MyPassword'
];

$transifex = new Transifex($options, $http);
```

### Supported Options

Below is a list of options that are supported in the `Transifex` object and API class objects; these may be set by injecting an options array when instantiating the `Transifex` object or using the `getOption()` method.

- 'api.username' - The username of the user account you are using to authenticate to the Transifex API
- 'api.password' - The password of the user account you are using to authenticate to the Transifex API
- 'base_uri' - The base API URL for connecting to the Transifex API, this typically should remain unchanged
- 'object.namespace' - A custom base namespace to locate `TransifexObject` implementations in

Please refer to the [Guzzle documentation](http://docs.guzzlephp.org/en/latest/) for information on how to configure the Guzzle HTTP client.

### Retrieving a TransifexObject instance

All API connectors extend the base `TransifexObject` class. API objects are named based on their grouping in the Transifex API documentation. To retrieve an object connecting to the "formats" API endpoints, simply execute this code:

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Formats $formats */
$formats = (new Transifex)->get('formats');
```

The `get()` method requires one parameter, the object name, and this should be a lower-cased string with no spaces. For API endpoints such as "Language info", you would retrieve this API object by calling `$transifex->get('languageinfo')`. A new object is instantiated with each call to the `get()` method.

The `get()` method supports retrieving objects in custom namespaces and includes fallback support for using the default object namespace. The custom namespace can be set with the `object.namespace` option. This is useful for extending the base object classes to add functionality or features as needed.

The class name within its namespace should match the name supplied to the `get()` method. For example, supposing your custom code is in the `My\Custom\Transifex` namespace and you had extended the [Projects](Projects.md) class, the following code would instantiate the `Transifex` object and enable the `get()` method to find your custom class:

```php
use BabDev\Transifex\Transifex;

// Build our options array
$options = [
	'object.namespace' => 'My\Custom\Transifex'
];

$transifex = new Transifex($options, $http);

/** @var \My\Custom\Transifex\Projects $projects */
$projects = $transifex->get('projects');

// This will return a default formats object since our custom namespace does not include an override for this class
/** @var \BabDev\Transifex\Formats $formats */
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
use BabDev\Transifex\Transifex;

// Build our options array setting our API credentials to authenticate
$options = [
	'api.username' => 'MyUsername',
	'api.password' => 'MyPassword'
];

$transifex = new Transifex($options);

// The trailing slash should be omitted on this value
$transifex->setOption('object.namespace', 'My\Custom\Transifex');

// $namespace = 'My\Custom\Transifex'
$namespace = $transifex->getOption('object.namespace');

// $bar = null since our option is not set
$bar = $transifex->getOption('foo');

// $bar = 'goo' since we have supplied a default value for our non-set option
$bar = $transifex->getOption('foo', 'goo');
```

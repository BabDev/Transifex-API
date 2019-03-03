## FactoryInterface

The `FactoryInterface` describes a factory class responsible for creating the API connector classes used for communicating with the Transifex API.

### Retrieving an API connector class

The factory is responsible for creating an [`ApiConnector`](ApiConnector.md) instance to communicate with the selected API segment.

```php
/** @var \BabDev\Transifex\ApiConnector $connector */
$connector = $factory->createApiConnector('translations');
```

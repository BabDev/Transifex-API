## Statistics

The `Statistics` class is the interface to Transifex' [statistics API](http://docs.transifex.com/api/statistics/) endpoints.

### Getting a Statistics object

An instance of the `Statistics` class should be retrieved through the `Transifex` class' `get()` factory.

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Statistics $statistics */
$statistics = (new Transifex())->get('statistics');
```

### Get a resource's statistics

To get the resource's statistics, call the `Statistics::getStatistics()` method.

This method has two required parameters:

* The slug for the project (string)
* The slug for the resource (string)

This method also has one additional optional parameter:

* A language code to filter statistics on (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('statistics')->getStatistics('my-project', 'resource-1');
```

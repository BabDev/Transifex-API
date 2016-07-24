## Formats

The `Formats` class is the interface to Transifex' [formats API](http://docs.transifex.com/api/formats/) endpoints.

### Getting a Formats object

An instance of the `Formats` class should be retrieved through the `Transifex` class' `get()` factory.

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Formats $formats */
$formats = (new Transifex())->get('formats');
```

### Get supported file formats

To retrieve the supported file formats from the Transifex API, call the `Formats::getFormats()` method.

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('formats')->getFormats();
```

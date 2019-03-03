## Formats

The `Formats` class is the interface to Transifex' [formats API](http://docs.transifex.com/api/formats/) endpoints.

### Getting a Formats object

An instance of the `Formats` class should be retrieved through the `Transifex` class' `get()` factory.

```php
/** @var \BabDev\Transifex\Connector\Formats $formats */
$formats = $transifex->get('formats');
```

### Get supported file formats

To retrieve the supported file formats from the Transifex API, call the `Formats::getFormats()` method.

```php
$apiResponse = $transifex->get('formats')->getFormats();
```

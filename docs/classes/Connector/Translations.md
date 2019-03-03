## Translations

The `Translations` class is the interface to Transifex' [translations API](http://docs.transifex.com/api/translations/) endpoints.

### Getting a Translations object

An instance of the `Translations` class should be retrieved through the `Transifex` class' `get()` factory.

```php
/** @var \BabDev\Transifex\Connector\Translations $translations */
$translations = $transifex->get('translations');
```

### Get a resource's translation

To get the translation for a resource, call the `Translations::getTranslation()` method.

This method has three required parameters:

* The slug for the project (string)
* The slug for the resource (string)
* The language code for the requested translation (string)

This method also has one additional optional parameter:

* A flag to retrieve additional project details (string, defaults as an empty string)

```php
$apiResponse = $transifex->get('translations')->getTranslation('my-project', 'resource-1', 'fr-FR');
```

### Update a resource's translation

To update a resource's translation, call the `Translations::updateTranslation()` method.

This method has four required parameters:

* The slug for the project (string)
* The slug for the resource (string)
* The language code for the requested translation (string)
* The resource's content, this may be either a string containing the raw contents or a filename to be loaded (string)

This method also has one additional optional parameter:

* The resource type provided in the fourth parameter, must be either 'string' or 'file' (string)

```php
$apiResponse = $transifex->get('translations')->updateTranslation('my-project', 'resource-1', 'fr-FR', 'TEST="Mon test Chaîne"');
```

If a filename has been provided and the file does not exist, an `\InvalidArgumentException` is thrown.

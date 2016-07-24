## Languageinfo

The `Languageinfo` class is the interface to Transifex' [language info API](http://docs.transifex.com/api/language_info/) endpoints.

### Getting a Languageinfo object

An instance of the `Languageinfo` class should be retrieved through the `Transifex` class' `get()` factory.

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Languageinfo $formats */
$languageInfo = (new Transifex())->get('languageinfo');
```

### Get information on a supported language

To retrieve information about a single language from the Transifex API, call the `Languageinfo::getLanguage()` method.

This method has one required parameter:

* The language code to retrieve (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languageinfo')->getLanguage('en-US');
```

### Get information on all supported languages

To retrieve information about all supported languages from the Transifex API, call the `Languageinfo::getLanguages()` method.

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languageinfo')->getLanguages();
```

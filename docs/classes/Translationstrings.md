## Translationstrings

The `Translationstrings` class is the interface to Transifex' [translation strings API](http://docs.transifex.com/api/translation_strings/) endpoints.

### Getting a Translationstrings object

An instance of the `Translationstrings` class should be retrieved through the `Transifex` class' `get()` factory.

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Translationstrings $translationStrings */
$translationStrings = (new Transifex())->get('translationstrings');
```

### Get a resource's pseudolocalization strings

To get the pseudolocalization strings for a resource, call the `Translationstrings::getPseudolocalizationStrings()` method.

This method has two required parameters:

* The slug for the project (string)
* The slug for the resource (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('translationstrings')->getPseudolocalizationStrings('my-project', 'resource-1');
```

### Get a resource's translation strings

To update a resource's translation, call the `Translationstrings::getStrings()` method.

This method has three required parameters:

* The slug for the project (string)
* The slug for the resource (string)
* The language code for the requested translation (string)

This method also has two additional optional parameter:

* A flag to retrieve additional translation details (boolean, defaults to false)
* An array containing optional additional params to send with the request, this array should contain all additional options not specified in the method's other parameters (associative array, defaults to an empty array)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('translationstrings')->getStrings('my-project', 'resource-1', 'fr-FR');
```

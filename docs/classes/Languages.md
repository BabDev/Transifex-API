## Languages

The `Languages` class is the interface to Transifex' [languages API](http://docs.transifex.com/api/languages/) endpoints.

### Getting a Languages object

An instance of the `Languages` class should be retrieved through the `Transifex` class' `get()` factory.

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Languages $languages */
$languages = (new Transifex())->get('languages');
```

### Create a language for a project

To create (add) a language for a project, call the `Languages::createLanguage()` method.

This method has three required parameters:

* The slug for the project (string)
* The language code for the new language (string)
* An array containing the usernames of the coordinators for the language (array of strings)

This method also has two optional parameters to pass additional information:

* An array containing optional additional params to send with the request, this array should contain the 'translators', 'reviewers', and 'list' options with the option's name as a key in the array (associative array, defaults to an empty array)
* A boolean flag that if true, the API call does not fail and instead will return a list of invalid usernames (boolean, default false)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->createLanguage('my-project', 'en-US', ['mbabker']);
```

The API requires at least one username to be provided. If the coordinators array is empty, an `\InvalidArgumentException` is thrown.

### Delete a language for a project

To delete a language for a project, call the `Languages::deleteLanguage()` method.

This method has two required parameters:

* The slug for the project (string)
* The language code for the language to delete (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->deleteLanguage('my-project', 'en-US');
```

### Get the coordinators for a project's language

To get the coordinators for a project's language, call the `Languages::getCoordinators()` method.

This method has two required parameters:

* The slug for the project (string)
* The language code for the language to query (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->getCoordinators('my-project', 'en-US');
```

### Get the details for a project's language

To get the details for a project's language, call the `Languages::getLanguage()` method.

This method has two required parameters:

* The slug for the project (string)
* The language code for the language to query (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->getLanguage('my-project', 'en-US');
```

### Get the project's languages

To get the project's languages, call the `Languages::getLanguages()` method.

This method has one required parameter:

* The slug for the project (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->getLanguages('my-project');
```

### Get the reviewers for a project's language

To get the reviewers for a project's language, call the `Languages::getReviewers()` method.

This method has two required parameters:

* The slug for the project (string)
* The language code for the language to query (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->getReviewers('my-project', 'en-US');
```

### Get the translators for a project's language

To get the translators for a project's language, call the `Languages::getTranslators()` method.

This method has two required parameters:

* The slug for the project (string)
* The language code for the language to query (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->getTranslators('my-project', 'en-US');
```

### Update the coordinators for a project's language

To update the coordinators for a project's language, call the `Languages::updateCoordinators()` method.

This method has three required parameters:

* The slug for the project (string)
* The language code for the language to be updated (string)
* An array containing the usernames of the coordinators for the language (array of strings)

This method also has one optional parameter to pass additional information:

* A boolean flag that if true, the API call does not fail and instead will return a list of invalid usernames (boolean, default false)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->updateCoordinators('my-project', 'en-US', ['mbabker']);
```

The API requires at least one username to be provided. If the coordinators array is empty, an `\InvalidArgumentException` is thrown.

### Update a language for a project

To update a language for a project, call the `Languages::updateLanguage()` method.

This method has three required parameters:

* The slug for the project (string)
* The language code for the language to updated (string)
* An array containing the usernames of the coordinators for the language (array of strings)

This method also has one optional parameter to pass additional information:

* An array containing optional additional params to send with the request, this array should contain the 'translators' and 'reviewers' options with the option's name as a key in the array (associative array, defaults to an empty array)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->updateLanguage('my-project', 'en-US', ['mbabker']);
```

The API requires at least one username to be provided. If the coordinators array is empty, an `\InvalidArgumentException` is thrown.

### Update the reviewers for a project's language

To update the reviewers for a project's language, call the `Languages::updateReviewers()` method.

This method has three required parameters:

* The slug for the project (string)
* The language code for the language to be updated (string)
* An array containing the usernames of the reviewers for the language (array of strings)

This method also has one optional parameter to pass additional information:

* A boolean flag that if true, the API call does not fail and instead will return a list of invalid usernames (boolean, default false)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->updateReviewers('my-project', 'en-US', ['mbabker']);
```

The API requires at least one username to be provided. If the reviewers array is empty, an `\InvalidArgumentException` is thrown.

### Update the translators for a project's language

To update the translators for a project's language, call the `Languages::updateTranslators()` method.

This method has three required parameters:

* The slug for the project (string)
* The language code for the language to be updated (string)
* An array containing the usernames of the translators for the language (array of strings)

This method also has one optional parameter to pass additional information:

* A boolean flag that if true, the API call does not fail and instead will return a list of invalid usernames (boolean, default false)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('languages')->updateTranslators('my-project', 'en-US', ['mbabker']);
```

The API requires at least one username to be provided. If the translators array is empty, an `\InvalidArgumentException` is thrown.

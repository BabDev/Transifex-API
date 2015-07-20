## Overview

The Transifex API package provides a PHP interface for interacting with the [Transifex API](http://docs.transifex.com/api/).

### Basic Use

The primary interface for interacting with the Transifex package is the [Transifex](classes/Transifex.md) class.  This class serves as
a factory object of sorts and allows developers to manage the options used by the API objects and HTTP connector as well as retrieve
instances of the API objects.  To create a `Transifex` object, you only need to instantiate it.

```php
use BabDev\Transifex\Transifex;

$transifex = new Transifex;
```

The constructor takes two optional arguments which are documented in the [class documentation](classes/Transifex.md) page.

Once instantiated, the options which are used by the API objects can be managed through the `getOption()` and `setOption()` methods.  For example, to
define a custom namespace to locate API connector objects, you could use the following code:

```php
use BabDev\Transifex\Transifex;

$transifex = new Transifex;

// The trailing slash should be omitted on this value
$transifex->setOption('object.namespace', 'My\Custom\Transifex');

// $namespace = 'My\Custom\Transifex'
$namespace = $transifex->getOption('object.namespace');
```

To retrieve an instance of an API object, you would use the `get()` method.  API objects are named based on the documented sections of the
Transifex API.  To retrieve an object that can interface with the "formats" API section, you would use the following code:

```php
use BabDev\Transifex\Transifex;

$transifex = new Transifex;

/** @var \BabDev\Transifex\Formats $formats */
$formats = $transifex->get('formats');
```

The `get()` method optionally supports locating objects in a custom namespace to enable developers to add custom connectors or extend the base
API classes.  This behavior is documented in the [class documentation](classes/Transifex.md) page.

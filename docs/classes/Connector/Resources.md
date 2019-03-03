## Resources

The `Resources` class is the interface to Transifex' [resources API](http://docs.transifex.com/api/resources/) endpoints.

### Getting a Resources object

An instance of the `Resources` class should be retrieved through the `Transifex` class' `get()` factory.

```php
/** @var \BabDev\Transifex\Connector\Resources $resources */
$resources = $transifex->get('resources');
```

### Create a resource

To create a new resource in a project, call the `Resources::createResource()` method.

This method has three required parameters:

* The slug for the project (string)
* The name of the resource (string)
* The slug for the resource (string)
* The resource's file type (string)

This method also has one optional parameter to pass additional information:

* An array containing optional additional params to send with the request, this array should contain all additional options not specified in the method's other parameters (associative array, defaults to an empty array)

NOTE: To upload contents for this resource, this method allows either a filename or a string containing the contents. The filename should be passed in the 'file' key of the options array and the string contents passed in the 'content' key.

```php
$apiResponse = $transifex->get('resources')->createResource('my-project', 'Resource 1', 'resource-1', 'INI');
```

If a filename has been provided and the file does not exist, an `\InvalidArgumentException` is thrown.

### Delete a resource

To delete a project's resource, call the `Resources::deleteResource()` method.

This method has two required parameters:

* The slug for the project (string)
* The slug for the resource (string)

```php
$apiResponse = $transifex->get('resources')->deleteResource('my-project', 'resource-1');
```

### Get information about a resource

To get information about a resource, call the `Resources::getResource()` method.

This method has two required parameters:

* The slug for the project (string)
* The slug for the resource (string)

This method also has one additional optional parameter:

* A flag to retrieve additional project details (boolean, defaults to false)

```php
$apiResponse = $transifex->get('resources')->getResource('my-project', 'resource-1');
```

### Get a resource's contents

To get the resource's contents, call the `Resources::getResourceContent()` method.

This method has two required parameters:

* The slug for the project (string)
* The slug for the resource (string)

```php
$apiResponse = $transifex->get('resources')->getResourceContent('my-project', 'resource-1');
```

### Get the list of the project's resources

To get the list of of the project's resources, call the `Resources::getResources()` method.

This method has one required parameter:

* The slug for the project (string)

```php
$apiResponse = $transifex->get('resources')->getResources('my-project');
```

### Update a resource's content

To update a resource's content, call the `Resources::updateResourceContent()` method.

This method has three required parameters:

* The slug for the project (string)
* The slug for the resource (string)
* The resource's content, this may be either a string containing the raw contents or a filename to be loaded (string)

This method also has one additional optional parameter:

* The resource type provided in the third parameter, must be either 'string' or 'file' (string)

```php
$apiResponse = $transifex->get('resources')->updateResourceContent('my-project', 'resource-1', 'TEST="My Test String"');
```

If a filename has been provided and the file does not exist, an `\InvalidArgumentException` is thrown.

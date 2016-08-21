## Projects

The `Projects` class is the interface to Transifex' [projects API](http://docs.transifex.com/api/projects/) endpoints.

### Getting a Projects object

An instance of the `Projects` class should be retrieved through the `Transifex` class' `get()` factory.

```php
use BabDev\Transifex\Transifex;

/** @var \BabDev\Transifex\Projects $projects */
$projects = (new Transifex())->get('projects');
```

### Create a project

To create a new project, call the `Projects::createProject()` method.

This method has three required parameters:

* The name of the project (string)
* The slug for the project (string)
* The project's description (string)
* The source (default) language code for the new project (string)

This method also has one optional parameter to pass additional information:

* An array containing optional additional params to send with the request, this array should contain all additional options not specified in the method's other parameters (associative array, defaults to an empty array)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('projects')->createProject('My Project', 'my-project', 'This is my new project', 'en-US');
```

Transifex requires that open source projects specify a repository URL. If this is not present, an `\InvalidArgumentException` will be thrown.

If the project's license is specified and is not an allowed value, an `\InvalidArgumentException` is thrown.

### Delete a project

To delete a project, call the `Projects::deleteProject()` method.

This method has one required parameter:

* The slug for the project (string)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('projects')->deleteProject('my-project');
```

### Get information about a project

To get information about a project, call the `Projects::getProject()` method.

This method has one required parameter:

* The slug for the project (string)

This method also has one additional optional parameter:

* A flag to retrieve additional project details (boolean, defaults to false)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('projects')->getProject('my-project');
```

### Get the projects the authenticated user is a member of

To get the list of projects the authenticated user is a member of, call the `Projects::getProjects()` method.

This method has no parameters.

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('projects')->getProjects();
```

### Update a project

To update a project, call the `Projects::updateProject()` method.

This method has two required parameters:

* The slug for the project (string)
* An array containing the project details to update (associative array)

```php
use BabDev\Transifex\Transifex;

$apiResponse = (new Transifex())->get('projects')->updateProject('my-project', ['name' => 'My Project']);
```

If the data array is empty, a `\RuntimeException` is thrown. If the project's license is updated and is not an allowed value, an `\InvalidArgumentException` is thrown.

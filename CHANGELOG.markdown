CHANGELOG for the Transifex API Package
===============

* 2.0.0

 * Add support for custom namespaces to `Transifex::get()`
 * Refactor API connector methods to return a full `Joomla\Http\Response` object
 * Removed magic getter in `Transifex` and associated class member vars
 * Support a default option in `Transifex::getOption()`

* 1.2.0 (2015-07-13)

 * Add `Transifex::get()` to fetch API objects
 * Deprecated magic getter in `Transifex` and associated class member vars for storing objects

* 1.1.0 (2015-07-12)

 * Deprecated `TransifexObject::processResponse()`, 2.0 will return the full `Joomla\Http\Response` object instead of processing the response internally

* 1.0.0 (2014-10-20)

 * Initial stable release

CHANGELOG for the Transifex API Package
===============

* 2.0.0

 * Refactor API connector methods to return a full `Joomla\Http\Response` object
 * Removed `TransifexObject::processResponse()`
 * Support a default option in `Transifex::getOption()`

* 1.1.0 (2015-07-12)

 * Deprecated `TransifexObject::processResponse()`, 2.0 will return the full `Joomla\Http\Response` object instead of processing the response internally

* 1.0.0 (2014-10-20)

 * Initial stable release

<?php
/**
 * Prepares a minimalist framework for unit testing.
 *
 * @package    BabDev.UnitTest
 *
 * @copyright  Copyright (C) 2012 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

define('_JEXEC', 1);

// Fix magic quotes.
@ini_set('magic_quotes_runtime', 0);

// Maximize error reporting.
@ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
 * Ensure that required path constants are defined.  These can be overridden within the phpunit.xml file
 * if you choose to create a custom version of that file.
 */
if (!defined('BDPATH_TESTS'))
{
	define('BDPATH_TESTS', realpath(__DIR__));
}
if (!defined('BDPATH_PLATFORM'))
{
	define('BDPATH_PLATFORM', realpath(dirname(BDPATH_TESTS) . '/libraries'));
}

/*
 * There will be some dependencies on Joomla Platform classes to properly test all classes.
 * This assumes the BabDev Libraries are checked out at the same level as the Joomla Platform
 * on your local system.  This can be overridden within the phpunit.xml file.
 */
if (!defined('JPATH_PLATFORM'))
{
	define('JPATH_PLATFORM', dirname(dirname(__DIR__)) . '/joomla-platform/libraries');
}

// Import the Joomla Platform.
require_once JPATH_PLATFORM . '/import.php';

// Register the BabDev Library classes.
JLoader::registerPrefix('BD', dirname(__DIR__) . '/libraries/babdev');

// Register the Joomla Platform test classes.
JLoader::registerPrefix('Test', dirname(dirname(__DIR__)) . '/joomla-platform/tests/core');

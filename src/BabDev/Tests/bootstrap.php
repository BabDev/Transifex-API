<?php
/**
 * Prepares a minimalist framework for unit testing.
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

// Fix magic quotes.
@ini_set('magic_quotes_runtime', 0);

// Maximize error reporting.
@ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
 * Ensure that required path constants are defined.  These can be overridden within the phpunit.xml file
 * if you chose to create a custom version of that file.
 */
if (!defined('JPATH_ROOT'))
{
	define('JPATH_ROOT', realpath(dirname(dirname(dirname(__DIR__)))));
}

// Search for the Composer autoload file
$composerAutoload = JPATH_ROOT . '/vendor/autoload.php';

if (file_exists($composerAutoload))
{
	include_once $composerAutoload;
}

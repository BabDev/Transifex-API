<?php
/**
 * BabDev HTTP Package
 *
 * The BabDev HTTP package is a fork of the Joomla HTTP package as found in Joomla! CMS 3.1.1
 * and provides selected bug fixes and a single codebase for consistent use in CMS 2.5 and newer.
 *
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Http;

use Joomla\Registry\Registry;

/**
 * HTTP factory class.
 *
 * @since  1.0
 */
class HttpFactory
{
	/**
	 * Method to retrieve a Http instance.
	 *
	 * @param   Registry  $options   Client options object.
	 * @param   mixed     $adapters  Adapter (string) or queue of adapters (array) to use for communication.
	 *
	 * @return  Http  Http class
	 *
	 * @since   1.0
	 */
	public static function getHttp(Registry $options = null, $adapters = null)
	{
		if (empty($options))
		{
			$options = new Registry;
		}

		return new Http($options, static::getAvailableDriver($options, $adapters));
	}

	/**
	 * Finds an available HTTP transport object for communication
	 *
	 * @param   Registry  $options  Option for creating http transport object
	 * @param   mixed     $default  Adapter (string) or queue of adapters (array) to use
	 *
	 * @return  TransportInterface  Transport object
	 *
	 * @since   1.0
	 */
	public static function getAvailableDriver(Registry $options, $default = null)
	{
		if (is_null($default))
		{
			$availableAdapters = static::getHttpTransports();
		}
		else
		{
			settype($default, 'array');
			$availableAdapters = $default;
		}

		// Check if there are available HTTP transport adapters
		if (!count($availableAdapters))
		{
			return false;
		}

		foreach ($availableAdapters as $adapter)
		{
			/* @type  TransportInterface  $class */
			$class = __NAMESPACE__ . '\\Transport\\' . ucfirst($adapter);

			if (class_exists($class))
			{
				if ($class::isSupported())
				{
					return new $class($options);
				}
			}
		}

		return false;
	}

	/**
	 * Get the HTTP transport handlers
	 *
	 * @return  array  An array of available transport handlers
	 *
	 * @since   1.0
	 */
	public static function getHttpTransports()
	{
		$names = array();
		$iterator = new \DirectoryIterator(__DIR__ . '/Transport');

		/* @type  \DirectoryIterator  $file */
		foreach ($iterator as $file)
		{
			$fileName = $file->getFilename();

			// Only load for php files.
			if ($file->isFile() && $file->getExtension() == 'php')
			{
				$names[] = substr($fileName, 0, strrpos($fileName, '.'));
			}
		}

		return $names;
	}
}

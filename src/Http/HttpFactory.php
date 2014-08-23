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
	 * @param   array  $options   Client options array.
	 * @param   mixed  $adapters  Adapter (string) or queue of adapters (array) to use for communication.
	 *
	 * @return  Http
	 *
	 * @since   1.0
	 */
	public static function getHttp($options = array(), $adapters = null)
	{
		return new Http($options, static::getAvailableDriver($options, $adapters));
	}

	/**
	 * Finds an available HTTP transport object for communication
	 *
	 * @param   array  $options  Options array to inject into the TransportInterface
	 * @param   mixed  $default  Adapter (string) or queue of adapters (array) to use
	 *
	 * @return  TransportInterface|boolean  TransportInterface object or false if there is no available adapter
	 *
	 * @since   1.0
	 */
	public static function getAvailableDriver($options, $default = null)
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
		$names    = array();
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

		sort($names);

		return $names;
	}
}

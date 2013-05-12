<?php
/**
 * BabDev Transifex Package

 * @package     BabDev.Library
 * @subpackage  Transifex
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Base class for interacting with the Transifex API.
 *
 * @property-read  BDTransifexFormats       $formats       Transifex API object for the supported formats.
 * @property-read  BDTransifexProjects      $projects      Transifex API object for interacting with projects.
 * @property-read  BDTransifexResources     $resources     Transifex API object for interacting with project's resources.
 * @property-read  BDTransifexStatistics    $statistics    Transifex API object for a resource's statistics.
 * @property-read  BDTransifexTranslations  $translations  Transifex API object for a resource's translations.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifex
{
	/**
	 * Options for the Transifex object.
	 *
	 * @var    JRegistry
	 * @since  1.0
	 */
	protected $options;

	/**
	 * The HTTP client object to use in sending HTTP requests.
	 *
	 * @var    BDTransifexHttp
	 * @since  1.0
	 */
	protected $client;

	/**
	 * Transifex API object for the supported formats.
	 *
	 * @var    BDTransifexFormats
	 * @since  1.0
	 */
	protected $formats;

	/**
	 * Transifex API object for interacting with projects.
	 *
	 * @var    BDTransifexProjects
	 * @since  1.0
	 */
	protected $projects;

	/**
	 * Transifex API object for interacting with project's resources.
	 *
	 * @var    BDTransifexResources
	 * @since  1.0
	 */
	protected $resources;

	/**
	 * Transifex API object for a resource's statistics.
	 *
	 * @var    BDTransifexStatistics
	 * @since  1.0
	 */
	protected $statistics;

	/**
	 * Transifex API object for a resource's translations.
	 *
	 * @var    BDTransifexTranslations
	 * @since  1.0
	 */
	protected $translations;

	/**
	 * Constructor.
	 *
	 * @param   JRegistry        $options  Transifex options object.
	 * @param   BDTransifexHttp  $client   The HTTP client object.
	 *
	 * @since   1.0
	 */
	public function __construct(JRegistry $options = null, BDTransifexHttp $client = null)
	{
		$this->options = isset($options) ? $options : new JRegistry;
		$this->client  = isset($client) ? $client : new BDTransifexHttp($this->options);

		// Setup the default API url if not already set.
		$this->options->def('api.url', 'http://www.transifex.com/api/2');

		// Set the authentication type if not already set.
		$this->options->def('api.authentication', 'HTTP');
	}

	/**
	 * Magic method to lazily create API objects
	 *
	 * @param   string  $name  Name of property to retrieve.
	 *
	 * @return  BDTransifexObject  Transifex API object.
	 *
	 * @since   1.0
	 * @throws  InvalidArgumentException
	 */
	public function __get($name)
	{
		$class = 'BDTransifex' . ucfirst($name);

		if (class_exists($class))
		{
			if (isset($this->$name) == false)
			{
				$this->$name = new $class($this->options, $this->client);
			}

			return $this->$name;
		}

		throw new InvalidArgumentException(sprintf('Argument %s produced an invalid class name: %s', $name, $class));
	}

	/**
	 * Get an option from the BDTransifex instance.
	 *
	 * @param   string  $key  The name of the option to get.
	 *
	 * @return  mixed  The option value.
	 *
	 * @since   1.0
	 */
	public function getOption($key)
	{
		return $this->options->get($key);
	}

	/**
	 * Set an option for the BDTransifex instance.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  BDTransifex  This object for method chaining.
	 *
	 * @since   1.0
	 */
	public function setOption($key, $value)
	{
		$this->options->set($key, $value);

		return $this;
	}
}

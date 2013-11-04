<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Transifex;

use BabDev\Http\HttpFactory;

use Joomla\Registry\Registry;

/**
 * Base class for interacting with the Transifex API.
 *
 * @property-read  Formats       $formats       Transifex API object for the supported formats.
 * @property-read  Projects      $projects      Transifex API object for interacting with projects.
 * @property-read  Releases      $releases      Transifex API object for interacting with project's releases.
 * @property-read  Resources     $resources     Transifex API object for interacting with project's resources.
 * @property-read  Statistics    $statistics    Transifex API object for a resource's statistics.
 * @property-read  Translations  $translations  Transifex API object for a resource's translations.
 *
 * @since  1.0
 */
class Transifex
{
	/**
	 * Options for the Transifex object.
	 *
	 * @var    Registry
	 * @since  1.0
	 */
	protected $options;

	/**
	 * The HTTP client object to use in sending HTTP requests.
	 *
	 * @var    Http
	 * @since  1.0
	 */
	protected $client;

	/**
	 * Transifex API object for the supported formats.
	 *
	 * @var    Formats
	 * @since  1.0
	 */
	protected $formats;

	/**
	 * Transifex API object for interacting with projects.
	 *
	 * @var    Projects
	 * @since  1.0
	 */
	protected $projects;

	/**
	 * Transifex API object for interacting with project's releases.
	 *
	 * @var    Releases
	 * @since  1.0
	 */
	protected $releases;

	/**
	 * Transifex API object for interacting with project's resources.
	 *
	 * @var    Resources
	 * @since  1.0
	 */
	protected $resources;

	/**
	 * Transifex API object for a resource's statistics.
	 *
	 * @var    Statistics
	 * @since  1.0
	 */
	protected $statistics;

	/**
	 * Transifex API object for a resource's translations.
	 *
	 * @var    Translations
	 * @since  1.0
	 */
	protected $translations;

	/**
	 * Constructor.
	 *
	 * @param   Registry  $options  Transifex options object.
	 * @param   Http      $client   The HTTP client object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, Http $client = null)
	{
		$this->options = isset($options) ? $options : new Registry;

		// Set the authentication type if not already set.
		$this->options->def('api.authentication', 'HTTP');

		// Set the transport object for the HTTP object
		$transport = HttpFactory::getAvailableDriver($this->options, array('curl'));

		$this->client = isset($client) ? $client : new Http($this->options, $transport);

		// Setup the default API url if not already set.
		$this->options->def('api.url', 'https://www.transifex.com/api/2');
	}

	/**
	 * Magic method to lazily create API objects
	 *
	 * @param   string  $name  Name of property to retrieve.
	 *
	 * @return  TransifexObject  Transifex API object.
	 *
	 * @since   1.0
	 * @throws  \InvalidArgumentException
	 */
	public function __get($name)
	{
		$class = __NAMESPACE__ . '\\' . ucfirst(strtolower($name));

		if (class_exists($class))
		{
			if (isset($this->$name) == false)
			{
				$this->$name = new $class($this->options, $this->client);
			}

			return $this->$name;
		}

		throw new \InvalidArgumentException(sprintf('Argument %s produced an invalid class name: %s', $name, $class));
	}

	/**
	 * Get an option from the Transifex instance.
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
	 * Set an option for the Transifex instance.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  Transifex  This object for method chaining.
	 *
	 * @since   1.0
	 */
	public function setOption($key, $value)
	{
		$this->options->set($key, $value);

		return $this;
	}
}

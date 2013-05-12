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
	 */
	public function __get($name)
	{
		if ($name == 'formats')
		{
			if ($this->formats == null)
			{
				$this->formats = new BDTransifexFormats($this->options, $this->client);
			}

			return $this->formats;
		}

		if ($name == 'projects')
		{
			if ($this->projects == null)
			{
				$this->projects = new BDTransifexProjects($this->options, $this->client);
			}

			return $this->projects;
		}

		if ($name == 'resources')
		{
			if ($this->resources == null)
			{
				$this->resources = new BDTransifexResources($this->options, $this->client);
			}

			return $this->resources;
		}

		if ($name == 'statistics')
		{
			if ($this->statistics == null)
			{
				$this->statistics = new BDTransifexStatistics($this->options, $this->client);
			}

			return $this->statistics;
		}

		if ($name == 'translations')
		{
			if ($this->translations == null)
			{
				$this->translations = new BDTransifexTranslations($this->options, $this->client);
			}

			return $this->translations;
		}
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

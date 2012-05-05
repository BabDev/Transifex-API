<?php
/**
 * @package     BabDev.Library
 * @subpackage  Transifex
 *
 * @copyright   Copyright (C) 2012 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Base class for interacting with the Transifex API.
 *
 * @property-read  BDTransifexFormats     $formats     Transifex API object for the supported formats.
 * @property-read  BDTransifexStatistics  $statistics  Transifex API object for a resource's statistics.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifex
{
	/**
	 * @var    JRegistry  Options for the Transifex object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    BDTransifexHttp  The HTTP client object to use in sending HTTP requests.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    BDTransifexFormats  Transifex API object for the supported formats.
	 * @since  1.0
	 */
	protected $formats;

	/**
	 * @var    BDTransifexStatistics  Transifex API object for the supported formats.
	 * @since  1.0
	 */
	protected $statistics;

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

		if ($name == 'statistics')
		{
			if ($this->statistics == null)
			{
				$this->statistics = new BDTransifexStatistics($this->options, $this->client);
			}
			return $this->statistics;
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

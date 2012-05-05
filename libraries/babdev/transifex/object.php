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
 * Transifex API object class.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
abstract class BDTransifexObject
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
		$this->client = isset($client) ? $client : new BDTransifexHttp($this->options);
	}

	/**
	 * Method to build and return a full request URL for the request.  This method will
	 * add appropriate pagination details if necessary and also prepend the API url
	 * to have a complete URL for the request.
	 *
	 * @param   string  $path  URL to inflect
	 *
	 * @return  string  The request URL.
	 *
	 * @since   1.0
	 */
	protected function fetchUrl($path)
	{
		// Get a new JUri object fousing the api url and given path.
		$uri = new JUri($this->options->get('api.url') . $path);

		return (string) $uri;
	}
}

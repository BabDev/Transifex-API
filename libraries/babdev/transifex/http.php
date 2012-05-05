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
 * HTTP client class for connecting to the Transifex API.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexHttp extends JHttp
{
	/**
	 * @const  integer  Use no authentication for HTTP connections.
	 * @since  1.0
	 */
	const AUTHENTICATION_NONE = 0;

	/**
	 * @const  integer  Use basic authentication for HTTP connections.
	 * @since  1.0
	 */
	const AUTHENTICATION_BASIC = 1;

	/**
	 * @const  integer  Use OAuth authentication for HTTP connections.
	 * @since  1.0
	 */
	const AUTHENTICATION_OAUTH = 2;

	/**
	 * Constructor.
	 *
	 * @param   JRegistry       $options    Client options object.
	 * @param   JHttpTransport  $transport  The HTTP transport object.
	 *
	 * @since   1.0
	 */
	public function __construct(JRegistry $options = null, JHttpTransport $transport = null)
	{
		// Call the JHttp constructor to setup the object.
		parent::__construct($options, $transport);

		// Make sure the user agent string is defined.
		$this->options->def('userAgent', 'BDTransifex/2.0');

		// Set the default timeout to 120 seconds.
		$this->options->def('timeout', 120);
	}
}

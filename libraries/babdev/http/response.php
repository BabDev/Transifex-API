<?php
/**
 * BabDev HTTP Package
 *
 * The BabDev HTTP package is a fork of the Joomla HTTP package as found in Joomla! CMS 3.1.1
 * and provides selected bug fixes and a single codebase for consistent use in CMS 2.5 and newer.
 *
 * @package     BabDev.Library
 * @subpackage  HTTP
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * HTTP response data object class.
 *
 * @package     BabDev.Library
 * @subpackage  HTTP
 * @since       1.0
 */
class BDHttpResponse
{
	/**
	 * The server response code.
	 *
	 * @var    integer
	 * @since  1.0
	 */
	public $code;

	/**
	 * Response headers.
	 *
	 * @var    array
	 * @since  1.0
	 */
	public $headers = array();

	/**
	 * Server response body.
	 *
	 * @var    string
	 * @since  1.0
	 */
	public $body;
}

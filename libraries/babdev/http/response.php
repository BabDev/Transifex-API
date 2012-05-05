<?php
/**
 * @package     BabDev.Library
 * @subpackage  HTTP
 *
 * @copyright   Copyright (C) 2012 Michael Babker. All rights reserved.
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
	 * @var    integer  The server response code.
	 * @since  1.0
	 */
	public $code;

	/**
	 * @var    array  Response headers.
	 * @since  1.0
	 */
	public $headers = array();

	/**
	 * @var    string  Server response body.
	 * @since  1.0
	 */
	public $body;
}

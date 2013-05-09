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
 * HTTP transport class interface.
 *
 * @package     BabDev.Library
 * @subpackage  HTTP
 * @since       1.0
 */
interface BDHttpTransport
{
	/**
	 * Constructor.
	 *
	 * @param   JRegistry  $options  Client options object.
	 *
	 * @since   1.0
	 */
	public function __construct(JRegistry $options);

	/**
	 * Send a request to the server and return a BDHttpResponse object with the response.
	 *
	 * @param   string   $method     The HTTP method for sending the request.
	 * @param   JUri     $uri        The URI to the resource to request.
	 * @param   mixed    $data       Either an associative array or a string to be sent with the request.
	 * @param   array    $headers    An array of request headers to send with the request.
	 * @param   integer  $timeout    Read timeout in seconds.
	 * @param   string   $userAgent  The optional user agent string to send with the request.
	 *
	 * @return  BDHttpResponse
	 *
	 * @since   1.0
	 * @throws  RuntimeException
	 */
	public function request($method, JUri $uri, $data = null, array $headers = null, $timeout = null, $userAgent = null);

	/**
	 * Method to check if the HTTP transport layer is available for use
	 *
	 * @return  boolean  True if available else false
	 *
	 * @since   1.0
	 */
	public static function isSupported();
}

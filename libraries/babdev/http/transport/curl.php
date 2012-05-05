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
 * HTTP transport class for using cURL.
 *
 * @package     BabDev.Library
 * @subpackage  HTTP
 * @since       1.0
 */
class BDHttpTransportCurl implements BDHttpTransport
{
	/**
	 * The client options.
	 *
	 * @var    JRegistry
	 * @since  1.0
	 */
	protected $options;

	/**
	 * Constructor.
	 *
	 * @param   JRegistry  $options  Client options object.
	 *
	 * @since   1.0
	 * @throws  RuntimeException
	 */
	public function __construct(JRegistry $options)
	{
		if (!function_exists('curl_init') || !is_callable('curl_init'))
		{
			throw new RuntimeException('Cannot use a cURL transport when curl_init() is not available.');
		}

		$this->options = $options;
	}

	/**
	 * Send a request to the server and return a JHttpResponse object with the response.
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
	 */
	public function request($method, JUri $uri, $data = null, array $headers = null, $timeout = null, $userAgent = null)
	{
		// Setup the cURL handle.
		$ch = curl_init();

		// Set the request method.
		$options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);

		// Don't wait for body when $method is HEAD
		$options[CURLOPT_NOBODY] = ($method === 'HEAD');

		// Initialize the certificate store
		$options[CURLOPT_CAINFO] = __DIR__ . '/cacert.pem';

		// If data exists let's encode it and make sure our Content-type header is set.
		if (isset($data))
		{
			// If the data is a scalar value simply add it to the cURL post fields.
			if (is_scalar($data))
			{
				$options[CURLOPT_POSTFIELDS] = $data;
			}
			// Otherwise we need to encode the value first.
			else
			{
				$options[CURLOPT_POSTFIELDS] = http_build_query($data);
			}

			if (!isset($headers['Content-type']))
			{
				$headers['Content-type'] = 'application/x-www-form-urlencoded';
			}

			$headers['Content-length'] = strlen($options[CURLOPT_POSTFIELDS]);
		}

		// Build the headers string for the request.
		$headerArray = array();
		if (isset($headers))
		{
			foreach ($headers as $key => $value)
			{
				$headerArray[] = $key . ': ' . $value;
			}

			// Add the headers string into the stream context options array.
			$options[CURLOPT_HTTPHEADER] = $headerArray;
		}

		// If an explicit timeout is given user it.
		if (isset($timeout))
		{
			$options[CURLOPT_TIMEOUT] = (int) $timeout;
			$options[CURLOPT_CONNECTTIMEOUT] = (int) $timeout;
		}

		// If an explicit user agent is given use it.
		if (isset($userAgent))
		{
			$headers[CURLOPT_USERAGENT] = $userAgent;
		}

		/*
		 * Check if we're using HTTP Authentication
		 * If so, check if we have authentication credentials
		 * We're also making a couple of assumptions about the length of user's credentials
		 */
		if ($this->options->get('api.authentication') == 'HTTP')
		{
			if (strlen($this->options->get('api.username')) >= 2 && strlen($this->options->get('api.password')) >= 4)
			{
				$options[CURLOPT_HTTPAUTH] = CURLAUTH_ANY;
				$options[CURLOPT_USERPWD] = $this->options->get('api.username') . ':' . $this->options->get('api.password');

				// We need to set this so we can forward the authentication on redirects
				$options[CURLOPT_UNRESTRICTED_AUTH] = true;
			}
		}

		// Set the request URL.
		$options[CURLOPT_URL] = (string) $uri;

		// We want our headers. :-)
		$options[CURLOPT_HEADER] = true;

		// Return it... echoing it would be tacky.
		$options[CURLOPT_RETURNTRANSFER] = true;

		// Follow redirects
		$options[CURLOPT_FOLLOWLOCATION] = true;

		// Set the cURL options.
		curl_setopt_array($ch, $options);

		// Execute the request and close the connection.
		$content = curl_exec($ch);
		curl_close($ch);

		return $this->getResponse($content);
	}

	/**
	 * Method to get a response object from a server response.
	 *
	 * @param   string  $content  The complete server response, including headers.
	 *
	 * @return  BDHttpResponse
	 *
	 * @since   1.0
	 * @throws  UnexpectedValueException
	 */
	protected function getResponse($content)
	{
		// Create the response object.
		$return = new BDHttpResponse;

		// Split the response into headers and body.
		$response = explode("\r\n\r\n", $content);

		// The last item in the array should be the body, get it
		$return->body = array_pop($response);

		// Get the last set of response headers from the array.
		$headers = array_pop($response);

		// Explode the headers into an array
		$headers = explode("\r\n", $headers);

		// Get the response code from the first offset of the response headers.
		preg_match('/[0-9]{3}/', array_shift($headers), $matches);

		$code = $matches[0];

		if (is_numeric($code))
		{
			$return->code = (int) $code;
		}
		// No valid response code was detected.
		else
		{
			throw new UnexpectedValueException('No HTTP response code found.');
		}

		// Add the response headers to the response object.
		foreach ($headers as $header)
		{
			$pos = strpos($header, ':');
			$return->headers[trim(substr($header, 0, $pos))] = trim(substr($header, ($pos + 1)));
		}

		return $return;
	}

	/**
	 * Method to check if HTTP transport cURL is available for use
	 *
	 * @return boolean true if available, else false
	 *
	 * @since   12.1
	 */
	public static function isSupported()
	{
		return function_exists('curl_version') && curl_version();
	}
}

<?php
/**
 * BabDev HTTP Package
 *
 * The BabDev HTTP package is a fork of the Joomla HTTP package as found in Joomla! CMS 3.1.1
 * and provides selected bug fixes and a single codebase for consistent use in CMS 2.5 and newer.
 *
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Http\Transport;

use BabDev\Http\Response;
use BabDev\Http\TransportInterface;

use Joomla\Uri\UriInterface;

/**
 * HTTP transport class for using PHP streams.
 *
 * @since  1.0
 */
class Stream implements TransportInterface
{
	/**
	 * The client array.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $options;

	/**
	 * Constructor.
	 *
	 * @param   array  $options  Client options object.
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	public function __construct($options)
	{
		// Verify that fopen() is available.
		if (!static::isSupported())
		{
			throw new \RuntimeException('Cannot use a stream transport when fopen() is not available.');
		}

		// Verify that URLs can be used with fopen();
		if (!ini_get('allow_url_fopen'))
		{
			throw new \RuntimeException('Cannot use a stream transport when "allow_url_fopen" is disabled.');
		}

		$this->options = $options;
	}

	/**
	 * Send a request to the server and return a Response object with the response.
	 *
	 * @param   string        $method     The HTTP method for sending the request.
	 * @param   UriInterface  $uri        The URI to the resource to request.
	 * @param   array|string  $data       Either an associative array or a string to be sent with the request.
	 * @param   array         $headers    An array of request headers to send with the request.
	 * @param   integer       $timeout    Read timeout in seconds.
	 * @param   string        $userAgent  The optional user agent string to send with the request.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	public function request($method, UriInterface $uri, $data = null, array $headers = null, $timeout = null, $userAgent = null)
	{
		// Create the stream context options array with the required method offset.
		$options = array('method' => strtoupper($method));

		// If data exists let's encode it and make sure our Content-Type header is set.
		if (isset($data))
		{
			// If the data is a scalar value simply add it to the stream context options.
			if (is_scalar($data))
			{
				$options['content'] = $data;
			}
			// Otherwise we need to encode the value first.
			else
			{
				// The http_build_query method requests an array or object; make an array if we have a string
				if (is_string($data))
				{
					$data = array($data);
				}

				$options['content'] = http_build_query($data);
			}

			if (!isset($headers['Content-Type']))
			{
				$headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
			}

			// Add the relevant headers.
			$headers['Content-Length'] = strlen($options['content']);
		}

		// Check if we're using HTTP Authentication.  If so, check if we have authentication credentials
		if (isset($this->options['api.authentication']) && $this->options['api.authentication'] == 'HTTP')
		{
			if (isset($this->options['api.username']) && isset($this->options['api.password']))
			{
				$headers['Authorization'] = 'Basic ' . base64_encode($this->options['api.username'] . ':' . $this->options['api.password']);
			}
		}

		// Build the headers string for the request.
		$headerString = null;

		if (isset($headers))
		{
			foreach ($headers as $key => $value)
			{
				$headerString .= $key . ': ' . $value . "\r\n";
			}

			// Add the headers string into the stream context options array.
			$options['header'] = trim($headerString, "\r\n");
		}

		// If an explicit timeout is given user it.
		if (isset($timeout))
		{
			$options['timeout'] = (int) $timeout;
		}

		// If an explicit user agent is given use it.
		if (isset($userAgent))
		{
			$options['user_agent'] = $userAgent;
		}

		// Ignore HTTP errors so that we can capture them.
		$options['ignore_errors'] = 1;

		// Follow redirects.
		$options['follow_location'] = isset($this->options['follow_location']) ? (int) $this->options['follow_location'] : 1;

		// Create the stream context for the request.
		$context = stream_context_create(
			array(
				'http' => $options,
				'ssl' => array(
					'verify_peer'   => true,
					'cafile'        => __DIR__ . '/cacert.pem',
					'verify_depth'  => 5,
				)
			)
		);

		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', 'true');

		// Open the stream for reading.
		$stream = @fopen((string) $uri, 'r', false, $context);

		if (!$stream)
		{
			if (!$php_errormsg)
			{
				// Error but nothing from php? Create our own
				$php_errormsg = sprintf('Could not connect to resource: %s', $uri);
			}

			// Restore error tracking to give control to the exception handler
			ini_set('track_errors', $track_errors);

			throw new \RuntimeException($php_errormsg);
		}

		// Restore error tracking to what it was before.
		ini_set('track_errors', $track_errors);

		// Get the metadata for the stream, including response headers.
		$metadata = stream_get_meta_data($stream);

		// Get the contents from the stream.
		$content = stream_get_contents($stream);

		// Close the stream.
		fclose($stream);

		if (isset($metadata['wrapper_data']['headers']))
		{
			$headers = $metadata['wrapper_data']['headers'];
		}
		elseif (isset($metadata['wrapper_data']))
		{
			$headers = $metadata['wrapper_data'];
		}
		else
		{
			$headers = array();
		}

		return $this->getResponse($headers, $content);
	}

	/**
	 * Method to get a response object from a server response.
	 *
	 * @param   array   $headers  The response headers as an array.
	 * @param   string  $body     The response body as a string.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 * @throws  \UnexpectedValueException
	 */
	protected function getResponse(array $headers, $body)
	{
		// Create the response object.
		$return = new Response;

		// Set the body for the response.
		$return->body = $body;

		// Get the response code from the first offset of the response headers.
		preg_match('/[0-9]{3}/', array_shift($headers), $matches);
		$code = $matches[0];

		if (!is_numeric($code))
		{
			throw new \UnexpectedValueException('No HTTP response code found.');
		}

		$return->code = (int) $code;

		// Add the response headers to the response object.
		foreach ($headers as $header)
		{
			$pos = strpos($header, ':');
			$return->headers[trim(substr($header, 0, $pos))] = trim(substr($header, ($pos + 1)));
		}

		return $return;
	}

	/**
	 * Method to check if the HTTP transport layer is available for use
	 *
	 * @return  boolean  True if available else false
	 *
	 * @since   1.0
	 */
	public static function isSupported()
	{
		return function_exists('fopen') && is_callable('fopen');
	}
}

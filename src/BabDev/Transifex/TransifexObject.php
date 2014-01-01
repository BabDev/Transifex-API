<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex;

use BabDev\Http\HttpFactory;
use BabDev\Http\Response;

use Joomla\Registry\Registry;
use Joomla\Uri\Uri;

/**
 * Transifex API object class.
 *
 * @since  1.0
 */
abstract class TransifexObject
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

		// Set the transport object for the HTTP object
		$transport = HttpFactory::getAvailableDriver($this->options, array('curl'));

		$this->client = isset($client) ? $client : new Http($this->options, $transport);
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
		// Get a new Uri object fousing the api url and given path.
		$uri = new Uri($this->options->get('api.url') . $path);

		return (string) $uri;
	}

	/**
	 * Process the response and decode it.
	 *
	 * @param   Response  $response      The response.
	 * @param   integer   $expectedCode  The expected "good" code.
	 *
	 * @return  mixed
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	protected function processResponse(Response $response, $expectedCode = 200)
	{
		// Validate the response code.
		if ($response->code != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$error = json_decode($response->body);

			// Check if the error message is set; send a generic one if not
			if (isset($error->message))
			{
				$message = $error->message;
			}
			else
			{
				$message = 'No error message was returned from the server.';
			}

			throw new \DomainException($message, $response->code);
		}

		return json_decode($response->body);
	}
}

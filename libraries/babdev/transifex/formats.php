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
 * Transifex API Formats class.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexFormats extends BDTransifexObject
{
	/**
	 * Method to get the supported formats.
	 *
	 * @return  array  The supported formats from the API.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function getFormats()
	{
		// Build the request path.
		$path = '/formats';

		// Send the request.
		$response = $this->client->get($this->fetchUrl($path));

		// Validate the response code.
		if ($response->code != 200)
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

			throw new DomainException($message, $response->code);
		}

		return json_decode($response->body);
	}
}

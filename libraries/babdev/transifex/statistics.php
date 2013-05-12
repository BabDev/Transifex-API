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
 * Transifex API Statistics class.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexStatistics extends BDTransifexObject
{
	/**
	 * Method to get statistics on a specified resource.
	 *
	 * @param   string  $project   The slug for the project to pull from.
	 * @param   string  $resource  The slug for the resource to pull from.
	 * @param   string  $lang      An optional language code to return data only for a specified language.
	 *
	 * @return  array  The resource's statistics.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function getStatistics($project, $resource, $lang = null)
	{
		// Build the request path.
		$path = '/project/' . $project . '/resource/' . $resource . '/stats/' . $lang;

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

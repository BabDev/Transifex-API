<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Transifex;

/**
 * Transifex API Formats class.
 *
 * @since  1.0
 */
class Formats extends TransifexObject
{
	/**
	 * Method to get the supported formats.
	 *
	 * @return  array  The supported formats from the API.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getFormats()
	{
		// Build the request path.
		$path = '/formats';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

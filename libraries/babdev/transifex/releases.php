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
 * Transifex API Releases class.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexReleases extends BDTransifexObject
{
	/**
	 * Method to get data about the project's releases
	 *
	 * @param   string  $slug  The slug for the project
	 *
	 * @return  array  The release data from the API.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function getReleases($slug)
	{
		// Build the request path.
		$path = '/project/release/' . $slug . '/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

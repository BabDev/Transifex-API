<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Transifex;

/**
 * Transifex API Releases class.
 *
 * @link   http://support.transifex.com/customer/portal/articles/1009516-release-api
 * @since  1.0
 */
class Releases extends TransifexObject
{
	/**
	 * Method to get data about the project's releases
	 *
	 * @param   string  $project  The project slug
	 * @param   string  $release  The release slug
	 *
	 * @return  array  The release data from the API.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getRelease($project, $release)
	{
		// Build the request path.
		$path = '/project/' . $project . '/release/' . $release . '/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

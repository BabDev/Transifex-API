<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
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

<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Transifex;

/**
 * Transifex API Statistics class.
 *
 * @link   http://support.transifex.com/customer/portal/articles/1026125-statistics-api
 * @since  1.0
 */
class Statistics extends TransifexObject
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
	 * @throws  \DomainException
	 */
	public function getStatistics($project, $resource, $lang = null)
	{
		// Build the request path.
		$path = '/project/' . $project . '/resource/' . $resource . '/stats/' . $lang;

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

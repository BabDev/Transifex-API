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
 * Transifex API Resources class.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexResources extends BDTransifexObject
{
	/**
	 * Method to delete a resource within a project.
	 *
	 * @param   string  $project   The project the resource is part of
	 * @param   string  $resource  The resource slug within the project
	 *
	 * @return  array  The project details from the API.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function deleteResource($project, $resource)
	{
		// Build the request path.
		$path = '/project/' . $project . '/resource/' . $resource;

		// Send the request.
		return $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
	}

	/**
	 * Method to get information about a resource within a project.
	 *
	 * @param   string   $project   The project the resource is part of
	 * @param   string   $resource  The resource slug within the project
	 * @param   boolean  $details   True to retrieve additional project details
	 *
	 * @return  array  The project details from the API.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function getResource($project, $resource, $details = false)
	{
		// Build the request path.
		$path = '/project/' . $project . '/resource/' . $resource . '/';

		if ($details)
		{
			$path .= '?details';
		}

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to get information about a project's resources.
	 *
	 * @param   string  $project  The project to retrieve details for
	 *
	 * @return  array  The project details from the API.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function getResources($project)
	{
		// Build the request path.
		$path = '/project/' . $project . '/resources';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

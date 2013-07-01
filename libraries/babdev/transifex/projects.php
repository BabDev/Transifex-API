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
 * Transifex API Projects class.
 *
 * @package     BabDev.Library
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexProjects extends BDTransifexObject
{
	/**
	 * Method to create a project.
	 *
	 * @param   string  $name            The name of the project
	 * @param   string  $slug            The slug for the project
	 * @param   string  $description     A description of the project
	 * @param   string  $sourceLanguage  The source language code for the project
	 * @param   array   $options         Optional additional params to send with the request
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  DomainException
	 * @throws  InvalidArgumentException
	 */
	public function createProject($name, $slug, $description, $sourceLanguage, array $options = array())
	{
		// Build the request path.
		$path = '/projects/';

		// Build the request data.
		$data = array(
			'name' => $name,
			'slug' => $slug,
			'description' => $description,
			'source_language_code' => $sourceLanguage
		);

		// Set the long description if present
		if (isset($options['long_description']))
		{
			$data['long_description'] = $options['long_description'];
		}

		// Flag the repo as private if set
		if (isset($options['private']))
		{
			$data['private'] = $options['private'];
		}

		// Set the project homepage if set
		if (isset($options['homepage']))
		{
			$data['homepage'] = $options['homepage'];
		}

		// Set a project feed if present
		if (isset($options['feed']))
		{
			$data['feed'] = $options['feed'];
		}

		// Flag the repo for open contributions if set
		if (isset($options['anyone_submit']))
		{
			$data['anyone_submit'] = $options['anyone_submit'];
		}

		// Flag the repo as hidden if set
		if (isset($options['hidden']))
		{
			$data['hidden'] = $options['hidden'];
		}

		// Set the project's bug tracker if present
		if (isset($options['bug_tracker']))
		{
			$data['bug_tracker'] = $options['bug_tracker'];
		}

		// Set the project's translation instructions if present
		if (isset($options['trans_instructions']))
		{
			$data['trans_instructions'] = $options['trans_instructions'];
		}

		// Set the project tags if present
		if (isset($options['tags']))
		{
			$data['tags'] = $options['tags'];
		}

		// Set the project maintainers if present
		if (isset($options['maintainers']))
		{
			$data['maintainers'] = $options['maintainers'];
		}

		// Set the outsourced project if present
		if (isset($options['outsource']))
		{
			$data['outsource'] = $options['outsource'];
		}

		// auto_join flag (TODO: Document)
		if (isset($options['auto_join']))
		{
			$data['auto_join'] = $options['auto_join'];
		}

		// Set the license if present
		if (isset($options['license']))
		{
			$accepted = array('proprietary', 'permissive_open_source', 'other_open_source');

			// Ensure the license option is an allowed value
			if (!in_array($options['license'], $accepted))
			{
				throw new InvalidArgumentException(
					sprintf(
						'The license %s is not valid, accepted license values are %s',
						$options['license'],
						implode(', ', $accepted)
					)
				);
			}

			$data['license'] = $options['license'];
		}

		// fill_up_resources (TODO: Document)
		if (isset($options['fill_up_resources']))
		{
			$data['fill_up_resources'] = $options['fill_up_resources'];
		}

		// Send the request.
		return $this->processResponse(
			$this->client->post($this->fetchUrl($path), json_encode($data), array('Content-Type' => 'application/json')),
			201
		);
	}

	/**
	 * Method to delete a project.
	 *
	 * @param   string  $slug  The slug for the resource.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function deleteProject($slug)
	{
		// Build the request path.
		$path = '/project/' . $slug;

		// Send the request.
		return $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
	}

	/**
	 * Method to get information about a project.
	 *
	 * @param   string   $project  The project to retrieve details for
	 * @param   boolean  $details  True to retrieve additional project details
	 *
	 * @return  array  The project details from the API.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function getProject($project, $details = false)
	{
		// Build the request path.
		$path = '/project/' . $project . '/';

		if ($details)
		{
			$path .= '?details';
		}

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to get a list of projects the user is part of.
	 *
	 * @return  array  The list of projects from the API.
	 *
	 * @since   1.0
	 * @throws  DomainException
	 */
	public function getProjects()
	{
		// Build the request path.
		$path = '/projects/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to update a project.
	 *
	 * @param   string  $slug     The slug for the project
	 * @param   array   $options  Optional additional params to send with the request
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  DomainException
	 * @throws  InvalidArgumentException
	 * @throws  RuntimeException
	 */
	public function updateProject($slug, array $options = array())
	{
		// Build the request path.
		$path = '/project/' . $slug . '/';

		// Build the request data.
		$data = array();

		// Set the project name if present
		if (isset($options['name']))
		{
			$data['name'] = $options['name'];
		}

		// Set the description if present
		if (isset($options['description']))
		{
			$data['description'] = $options['description'];
		}

		// Set the long description if present
		if (isset($options['long_description']))
		{
			$data['long_description'] = $options['long_description'];
		}

		// Flag the repo as private if set
		if (isset($options['private']))
		{
			$data['private'] = $options['private'];
		}

		// Set the project homepage if set
		if (isset($options['homepage']))
		{
			$data['homepage'] = $options['homepage'];
		}

		// Set a project feed if present
		if (isset($options['feed']))
		{
			$data['feed'] = $options['feed'];
		}

		// Flag the repo for open contributions if set
		if (isset($options['anyone_submit']))
		{
			$data['anyone_submit'] = $options['anyone_submit'];
		}

		// Flag the repo as hidden if set
		if (isset($options['hidden']))
		{
			$data['hidden'] = $options['hidden'];
		}

		// Set the project's bug tracker if present
		if (isset($options['bug_tracker']))
		{
			$data['bug_tracker'] = $options['bug_tracker'];
		}

		// Set the project's translation instructions if present
		if (isset($options['trans_instructions']))
		{
			$data['trans_instructions'] = $options['trans_instructions'];
		}

		// Set the project tags if present
		if (isset($options['tags']))
		{
			$data['tags'] = $options['tags'];
		}

		// Set the project maintainers if present
		if (isset($options['maintainers']))
		{
			$data['maintainers'] = $options['maintainers'];
		}

		// Set the outsourced project if present
		if (isset($options['outsource']))
		{
			$data['outsource'] = $options['outsource'];
		}

		// auto_join flag (TODO: Document)
		if (isset($options['auto_join']))
		{
			$data['auto_join'] = $options['auto_join'];
		}

		// Set the license if present
		if (isset($options['license']))
		{
			$accepted = array('proprietary', 'permissive_open_source', 'other_open_source');

			// Ensure the license option is an allowed value
			if (!in_array($options['license'], $accepted))
			{
				throw new InvalidArgumentException(
					sprintf(
						'The license %s is not valid, accepted license values are %s',
						$options['license'],
						implode(', ', $accepted)
					)
				);
			}

			$data['license'] = $options['license'];
		}

		// fill_up_resources (TODO: Document)
		if (isset($options['fill_up_resources']))
		{
			$data['fill_up_resources'] = $options['fill_up_resources'];
		}

		// Make sure we actually have data to send
		if (empty($data))
		{
			throw new RuntimeException('There is no data to send to Transifex.');
		}

		// Send the request.
		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($data), array('Content-Type' => 'application/json')),
			200
		);
	}
}

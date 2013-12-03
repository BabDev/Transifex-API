<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Transifex;

/**
 * Transifex API Languages class.
 *
 * @link   http://support.transifex.com/customer/portal/articles/1009525-language-api
 * @since  1.0
 */
class Languages extends TransifexObject
{
	/**
	 * Method to create a language for a project.
	 *
	 * @param   string  $slug          The slug for the project
	 * @param   string  $langCode      The language code for the new language
	 * @param   array   $coordinators  An array of coordinators for the language
	 * @param   array   $options       Optional additional params to send with the request
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 * @throws  \InvalidArgumentException
	 */
	public function createLanguage($slug, $langCode, array $coordinators, array $options = array())
	{
		// Make sure the $coordinators array is not empty
		if (count($coordinators) < 1)
		{
			throw new \InvalidArgumentException('The coordinators array must contain at least one username.');
		}

		// Build the request path.
		$path = '/project/' . $slug . '/languages/';

		// Build the required request data.
		$data = array(
			'language_code' => $langCode,
			'coordinators' => $coordinators
		);

		// Set the translators if present
		if (isset($options['translators']))
		{
			$data['translators'] = $options['translators'];
		}

		// Set the reviewers if present
		if (isset($options['reviewers']))
		{
			$data['reviewers'] = $options['reviewers'];
		}

		// Set a mailing list e-mail address if present
		if (isset($options['list']))
		{
			$data['list'] = $options['list'];
		}

		// Send the request.
		return $this->processResponse(
			$this->client->post($this->fetchUrl($path), json_encode($data), array('Content-Type' => 'application/json')),
			201
		);
	}

	/**
	 * Method to delete a language within a project.
	 *
	 * @param   string  $project   The project to retrieve details for
	 * @param   string  $langCode  The language code to retrieve details for
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function deleteLanguage($project, $langCode)
	{
		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/';

		// Send the request.
		return $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
	}

	/**
	 * Method to get the coordinators for a language team in a project
	 *
	 * @param   string  $project   The project to retrieve details for
	 * @param   string  $langCode  The language code to retrieve details for
	 *
	 * @return  array  The coordinator information from the API.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getCoordinators($project, $langCode)
	{
		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/coordinators/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to get information about a given language in a project.
	 *
	 * @param   string  $project   The project to retrieve details for
	 * @param   string  $langCode  The language code to retrieve details for
	 *
	 * @return  array  The language details for the specified project from the API.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getLanguage($project, $langCode)
	{
		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to get a list of languages for a specified project.
	 *
	 * @param   string  $project  The project to retrieve details for
	 *
	 * @return  array  The language data for the project.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getLanguages($project)
	{
		// Build the request path.
		$path = '/project/' . $project . '/languages/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to get the reviewers for a language team in a project
	 *
	 * @param   string  $project   The project to retrieve details for
	 * @param   string  $langCode  The language code to retrieve details for
	 *
	 * @return  array  The reviewer information from the API.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getReviewers($project, $langCode)
	{
		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/reviewers/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to get the translators for a language team in a project
	 *
	 * @param   string  $project   The project to retrieve details for
	 * @param   string  $langCode  The language code to retrieve details for
	 *
	 * @return  array  The translators information from the API.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getTranslators($project, $langCode)
	{
		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/translators/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to update the coordinators for a language team in a project
	 *
	 * @param   string  $project       The project to retrieve details for
	 * @param   string  $langCode      The language code to retrieve details for
	 * @param   array   $coordinators  An array of coordinators for the language
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 * @throws  \InvalidArgumentException
	 */
	public function updateCoordinators($project, $langCode, array $coordinators)
	{
		// Make sure the $coordinators array is not empty
		if (count($coordinators) < 1)
		{
			throw new \InvalidArgumentException('The coordinators array must contain at least one username.');
		}

		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/coordinators/';

		// Send the request.
		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($coordinators), array('Content-Type' => 'application/json')),
			200
		);
	}

	/**
	 * Method to update a language within a project.
	 *
	 * @param   string  $slug          The slug for the project
	 * @param   string  $langCode      The language code for the new language
	 * @param   array   $coordinators  An array of coordinators for the language
	 * @param   array   $options       Optional additional params to send with the request
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 * @throws  \InvalidArgumentException
	 */
	public function updateLanguage($slug, $langCode, array $coordinators, array $options = array())
	{
		// Make sure the $coordinators array is not empty
		if (count($coordinators) < 1)
		{
			throw new \InvalidArgumentException('The coordinators array must contain at least one username.');
		}

		// Build the request path.
		$path = '/project/' . $slug . '/language/' . $langCode . '/';

		// Build the required request data.
		$data = array('coordinators' => $coordinators);

		// Set the translators if present
		if (isset($options['translators']))
		{
			$data['translators'] = $options['translators'];
		}

		// Set the reviewers if present
		if (isset($options['reviewers']))
		{
			$data['reviewers'] = $options['reviewers'];
		}

		// Send the request.
		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($data), array('Content-Type' => 'application/json')),
			200
		);
	}

	/**
	 * Method to update the reviewers for a language team in a project
	 *
	 * @param   string  $project    The project to retrieve details for
	 * @param   string  $langCode   The language code to retrieve details for
	 * @param   array   $reviewers  An array of reviewers for the language
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 * @throws  \InvalidArgumentException
	 */
	public function updateReviewers($project, $langCode, array $reviewers)
	{
		// Make sure the $reviewers array is not empty
		if (count($reviewers) < 1)
		{
			throw new \InvalidArgumentException('The reviewers array must contain at least one username.');
		}

		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/reviewers/';

		// Send the request.
		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($reviewers), array('Content-Type' => 'application/json')),
			200
		);
	}

	/**
	 * Method to update the translators for a language team in a project
	 *
	 * @param   string  $project      The project to retrieve details for
	 * @param   string  $langCode     The language code to retrieve details for
	 * @param   array   $translators  An array of translators for the language
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 * @throws  \InvalidArgumentException
	 */
	public function updateTranslators($project, $langCode, array $translators)
	{
		// Make sure the $translators array is not empty
		if (count($translators) < 1)
		{
			throw new \InvalidArgumentException('The translators array must contain at least one username.');
		}

		// Build the request path.
		$path = '/project/' . $project . '/language/' . $langCode . '/translators/';

		// Send the request.
		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($translators), array('Content-Type' => 'application/json')),
			200
		);
	}
}

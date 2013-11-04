<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Transifex;

/**
 * Transifex API Translations class.
 *
 * @since  1.0
 */
class Translations extends TransifexObject
{
	/**
	 * Method to get statistics on a specified resource.
	 *
	 * @param   string  $project   The slug for the project to pull from.
	 * @param   string  $resource  The slug for the resource to pull from.
	 * @param   string  $lang      The language to return the translation for.
	 *
	 * @return  array  The resource's translation in the specified language.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getTranslation($project, $resource, $lang)
	{
		// Build the request path.
		$path = '/project/' . $project . '/resource/' . $resource . '/translation/' . $lang;

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

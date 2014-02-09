<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex;

/**
 * Transifex API Translation Strings class.
 *
 * @link   http://support.transifex.com/customer/portal/articles/1026117-translation-strings-api
 * @since  1.0
 */
class Translationstrings extends TransifexObject
{
	/**
	 * Method to get the translation strings on a specified resource.
	 *
	 * @param   string   $project   The slug for the project to pull from.
	 * @param   string   $resource  The slug for the resource to pull from.
	 * @param   string   $lang      The language to return the translation for.
	 * @param   boolean  $details   Flag to retrieve additional details on the strings
	 * @param   array    $options   An array of additional options for the request
	 *
	 * @return  array  The resource's translation in the specified language.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getStrings($project, $resource, $lang, $details = false, $options = array())
	{
		// Build the request path.
		$path = '/project/' . $project . '/resource/' . $resource . '/translation/' . $lang . '/strings/';

		// Flag for when the query string starts
		$firstQuerySet = false;

		if ($details)
		{
			$path         .= '?details';
			$firstQuerySet = true;
		}

		if (isset($options['key']))
		{
			if ($firstQuerySet)
			{
				$path .= '\&key=' . $options['key'];
			}
			else
			{
				$path         .= '?key=' . $options['key'];
				$firstQuerySet = true;
			}
		}

		if (isset($options['context']))
		{
			if ($firstQuerySet)
			{
				$path .= '\&context=' . $options['context'];
			}
			else
			{
				$path .= '?context=' . $options['context'];
			}
		}

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

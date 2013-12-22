<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Transifex;

/**
 * Transifex API Language Information class.
 *
 * @link   http://support.transifex.com/customer/portal/articles/1069339-language-info-api
 * @since  1.0
 */
class LanguageInfo extends TransifexObject
{
	/**
	 * Method to get data on the specified language.
	 *
	 * @param   string  $lang  The language code to retrieve
	 *
	 * @return  array  The language data.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getLanguage($lang)
	{
		// Build the request path.
		$path = '/language/' . $lang . '/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}

	/**
	 * Method to get data on all supported API languages.
	 *
	 * @return  array  The language data.
	 *
	 * @since   1.0
	 * @throws  \DomainException
	 */
	public function getLanguages()
	{
		// Build the request path.
		$path = '/languages/';

		// Send the request.
		return $this->processResponse($this->client->get($this->fetchUrl($path)));
	}
}

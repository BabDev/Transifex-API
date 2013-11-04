<?php
/**
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\TransifexObject;

/**
 * Mock class for testing \BabDev\Transifex\TransifexObject
 *
 * @since  1.0
 */
class ObjectMock extends TransifexObject
{
	/**
	 * Method to build and return a full request URL for the request.  This method will
	 * add appropriate pagination details if necessary and also prepend the API url
	 * to have a complete URL for the request.
	 *
	 * @param   string  $path  URL to inflect
	 *
	 * @return  string  The request URL.
	 *
	 * @since   1.0
	 */
	public function fetchUrl($path)
	{
		return parent::fetchUrl($path);
	}
}

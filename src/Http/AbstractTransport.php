<?php
/**
 * BabDev HTTP Package
 *
 * The BabDev HTTP package is a fork of the Joomla HTTP package as found in Joomla! CMS 3.1.1
 * and provides selected bug fixes and a single codebase for consistent use in CMS 2.5 and newer.
 *
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Http;

/**
 * Abstract TransportInterface object
 *
 * @since  1.0
 */
abstract class AbstractTransport implements TransportInterface
{
	/**
	 * Process the headers for the object response
	 *
	 * @param   array  $headers  Array containing the response headers
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	protected function processReturnHeaders(array $headers)
	{
		$data = array();

		foreach ($headers as $header)
		{
			$pos = strpos($header, ':');
			$data[trim(substr($header, 0, $pos))] = trim(substr($header, ($pos + 1)));
		}

		return $data;
	}
}

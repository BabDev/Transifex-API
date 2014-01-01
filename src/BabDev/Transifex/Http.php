<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex;

use BabDev\Http\Http as BaseHttp;
use BabDev\Http\TransportInterface;

use Joomla\Registry\Registry;

/**
 * HTTP client class for connecting to the Transifex API.
 *
 * @since  1.0
 */
class Http extends BaseHttp
{
	/**
	 * Constructor.
	 *
	 * @param   Registry            $options    Client options object.
	 * @param   TransportInterface  $transport  The HTTP transport object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, TransportInterface $transport = null)
	{
		// Call the BaseHttp constructor to setup the object.
		parent::__construct($options, $transport);

		// Make sure the user agent string is defined.
		$this->options->def('userAgent', 'BDTransifex/2.0');

		// Set the default timeout to 120 seconds.
		$this->options->def('timeout', 120);
	}
}

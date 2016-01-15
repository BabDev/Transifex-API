<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex;

use Joomla\Http\Http as BaseHttp;
use Joomla\Http\TransportInterface;

/**
 * HTTP client class for connecting to the Transifex API.
 */
class Http extends BaseHttp
{
    /**
     * @param array              $options   Client options array.
     * @param TransportInterface $transport The HTTP transport object.
     */
    public function __construct($options = [], TransportInterface $transport = null)
    {
        // Call the BaseHttp constructor to setup the object.
        parent::__construct($options, $transport);

        // Make sure the user agent string is defined.
        if (!$this->getOption('userAgent')) {
            $this->setOption('userAgent', 'BDTransifex/2.0');
        }

        // Set the default timeout to 120 seconds.
        if (!$this->getOption('timeout')) {
            $this->setOption('timeout', 120);
        }
    }
}

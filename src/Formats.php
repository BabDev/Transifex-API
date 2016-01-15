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

/**
 * Transifex API Formats class.
 *
 * @link http://docs.transifex.com/developer/api/formats
 */
class Formats extends TransifexObject
{
    /**
     * Method to get the supported formats.
     *
     * @return \Joomla\Http\Response
     */
    public function getFormats()
    {
        return $this->processResponse($this->client->get($this->fetchUrl('/formats')));
    }
}

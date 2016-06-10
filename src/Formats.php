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

use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API Formats class.
 *
 * @link http://docs.transifex.com/api/formats/
 */
class Formats extends TransifexObject
{
    /**
     * Get the supported file formats.
     *
     * @return ResponseInterface
     */
    public function getFormats() : ResponseInterface
    {
        return $this->client->get('/api/2/formats', ['auth' => $this->getAuthData()]);
    }
}

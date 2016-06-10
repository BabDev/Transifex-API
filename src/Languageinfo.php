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
 * Transifex API Language Information class.
 *
 * @link http://docs.transifex.com/api/language_info/
 */
class Languageinfo extends TransifexObject
{
    /**
     * Get data on the specified language.
     *
     * @param string $lang The language code to retrieve
     *
     * @return ResponseInterface
     */
    public function getLanguage(string $lang) : ResponseInterface
    {
        return $this->client->get("/api/2/language/$lang/", ['auth' => $this->getAuthData()]);
    }

    /**
     * Get data on all supported API languages.
     *
     * @return ResponseInterface
     */
    public function getLanguages() : ResponseInterface
    {
        return $this->client->get('/api/2/language/', ['auth' => $this->getAuthData()]);
    }
}

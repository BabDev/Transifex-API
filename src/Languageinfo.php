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
 * Transifex API Language Information class.
 *
 * @link http://docs.transifex.com/developer/api/language_info
 */
class Languageinfo extends TransifexObject
{
    /**
     * Method to get data on the specified language.
     *
     * @param string $lang The language code to retrieve
     *
     * @return \Joomla\Http\Response
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
     * @return \Joomla\Http\Response
     */
    public function getLanguages()
    {
        // Build the request path.
        $path = '/languages/';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}

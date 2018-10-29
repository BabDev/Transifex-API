<?php declare(strict_types=1);

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
    public function getLanguage(string $lang): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri("/api/2/language/$lang/")));
    }

    /**
     * Get data on all supported API languages.
     *
     * @return ResponseInterface
     */
    public function getLanguages(): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri('/api/2/languages/')));
    }
}

<?php declare(strict_types=1);

namespace BabDev\Transifex\Connector;

use BabDev\Transifex\ApiConnector;
use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API Translation Strings class.
 *
 * @link http://docs.transifex.com/api/translation_strings/
 */
class Translationstrings extends ApiConnector
{
    /**
     * Method to get pseudolocalization strings on a specified resource.
     *
     * @param string $project  The slug for the project to pull from
     * @param string $resource The slug for the resource to pull from
     *
     * @return ResponseInterface
     */
    public function getPseudolocalizationStrings(string $project, string $resource): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri("/api/2/project/$project/resource/$resource/pseudo/?pseudo_type=MIXED")));
    }

    /**
     * Method to get the translation strings on a specified resource.
     *
     * @param string $project  The slug for the project to pull from
     * @param string $resource The slug for the resource to pull from
     * @param string $lang     The language to return the translation for
     * @param bool   $details  Flag to retrieve additional details on the strings
     * @param array  $options  An array of additional options for the request
     *
     * @return ResponseInterface
     */
    public function getStrings(
        string $project,
        string $resource,
        string $lang,
        bool $details = false,
        array $options = []
    ): ResponseInterface {
        $uri   = $this->createUri("/api/2/project/$project/resource/$resource/translation/$lang/strings/");
        $query = [];

        if ($details) {
            // Add details now because `http_build_query()` can't handle something that isn't a key/value pair
            $uri = $uri->withQuery('details');
        }

        if (isset($options['key'])) {
            $query['key'] = $options['key'];
        }

        if (isset($options['context'])) {
            $query['context'] = $options['context'];
        }

        if (!empty($query)) {
            if ($uri->getQuery() === '') {
                $uri = $uri->withQuery(\http_build_query($query));
            } else {
                $uri = $uri->withQuery($uri->getQuery() . '&' . \http_build_query($query));
            }
        }

        return $this->client->sendRequest($this->createRequest('GET', $uri));
    }
}

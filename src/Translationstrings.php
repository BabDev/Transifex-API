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

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API Translation Strings class.
 *
 * @link http://docs.transifex.com/api/translation_strings/
 */
class Translationstrings extends TransifexObject
{
    /**
     * Method to get pseudolocalization strings on a specified resource.
     *
     * @param string $project  The slug for the project to pull from
     * @param string $resource The slug for the resource to pull from
     *
     * @return ResponseInterface
     */
    public function getPseudolocalizationStrings(string $project, string $resource) : ResponseInterface
    {
        return $this->client->request(
            'GET',
            $this->createUri("/api/2/project/$project/resource/$resource/pseudo/?pseudo_type=MIXED"),
            ['auth' => $this->getAuthData()]
        );
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
    ) : ResponseInterface {
        $uri = $this->createUri("/api/2/project/$project/resource/$resource/translation/$lang/strings/");

        if ($details) {
            $uri = Uri::withQueryValue($uri, 'details', null);
        }

        if (isset($options['key'])) {
            $uri = Uri::withQueryValue($uri, 'key', $options['key']);
        }

        if (isset($options['context'])) {
            $uri = Uri::withQueryValue($uri, 'context', $options['context']);
        }

        return $this->client->request('GET', $uri, ['auth' => $this->getAuthData()]);
    }
}

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
 * Transifex API Translations class.
 *
 * @link http://docs.transifex.com/api/translations/
 */
class Translations extends TransifexObject
{
    /**
     * Get translations on a specified resource.
     *
     * @param string $project  The slug for the project to pull from
     * @param string $resource The slug for the resource to pull from
     * @param string $lang     The language to return the translation for
     * @param string $mode     The mode of the downloaded file
     *
     * @return ResponseInterface
     */
    public function getTranslation(
        string $project,
        string $resource,
        string $lang,
        string $mode = ''
    ) : ResponseInterface {
        $uri = $this->createUri("/api/2/project/$project/resource/$resource/translation/$lang");

        if (!empty($mode)) {
            $uri = Uri::withQueryValue($uri, 'mode', $mode);
            $uri = Uri::withQueryValue($uri, 'file', null);
        }

        return $this->client->request('GET', $uri, ['auth' => $this->getAuthData()]);
    }

    /**
     * Update the content of a translation within a project.
     *
     * @param string $project  The project the resource is part of
     * @param string $resource The resource slug within the project
     * @param string $lang     The language to return the translation for
     * @param string $content  The content of the resource, this can either be a string of data or a file path
     * @param string $type     The type of content in the $content variable, this should be either string or file
     *
     * @return ResponseInterface
     */
    public function updateTranslation(
        string $project,
        string $resource,
        string $lang,
        string $content,
        string $type = 'string'
    ) : ResponseInterface {
        return $this->updateResource(
            $this->createUri("/api/2/project/$project/resource/$resource/translation/$lang"),
            $content,
            $type
        );
    }
}

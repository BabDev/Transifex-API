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
 * Transifex API Translations class.
 *
 * @link http://docs.transifex.com/developer/api/translations
 */
class Translations extends TransifexObject
{
    /**
     * Method to get statistics on a specified resource.
     *
     * @param string $project  The slug for the project to pull from.
     * @param string $resource The slug for the resource to pull from.
     * @param string $lang     The language to return the translation for.
     * @param string $mode     The mode of the downloaded file.
     *
     * @return \Joomla\Http\Response
     */
    public function getTranslation($project, $resource, $lang, $mode = '')
    {
        // Build the request path.
        $path = '/project/' . $project . '/resource/' . $resource . '/translation/' . $lang;

        if (!empty($mode)) {
            $path .= '?mode=' . $mode . '&file';
        }

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Method to update the content of a resource within a project.
     *
     * @param string $project  The project the resource is part of
     * @param string $resource The resource slug within the project
     * @param string $lang     The language to return the translation for.
     * @param string $content  The content of the resource.  This can either be a string of data or a file path.
     * @param string $type     The type of content in the $content variable.  This should be either string or file.
     *
     * @return \Joomla\Http\Response
     */
    public function updateTranslation($project, $resource, $lang, $content, $type = 'string')
    {
        // Build the request path.
        $path = '/project/' . $project . '/resource/' . $resource . '/translation/' . $lang;

        return $this->updateResource($path, $content, $type);
    }
}

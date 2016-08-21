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
 * Transifex API Resources class.
 *
 * @link http://docs.transifex.com/api/resources/
 */
class Resources extends TransifexObject
{
    /**
     * Create a resource.
     *
     * @param string $project  The slug for the project
     * @param string $name     The name of the resource
     * @param string $slug     The slug for the resource
     * @param string $fileType The file type of the resource
     * @param array  $options  Optional additional params to send with the request
     *
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function createResource(
        string $project,
        string $name,
        string $slug,
        string $fileType,
        array $options = []
    ) : ResponseInterface {
        // Build the request path.
        $path = "project/$project/resources/";

        // Build the required request data.
        $data = [
            'name'      => $name,
            'slug'      => $slug,
            'i18n_type' => $fileType,
        ];

        // Valid options to check
        $validOptions = [
            'accept_translations',
            'category',
            'priority',
        ];

        // Loop through the valid options and if we have them, add them to the request data
        foreach ($validOptions as $option) {
            if (isset($options[$option])) {
                $data[$option] = $options[$option];
            }
        }

        // Attach the resource data - it should be in the content key if this is a string or the file key if it's a file
        if (isset($options['content'])) {
            $data['content'] = $options['content'];
        } elseif (isset($options['file'])) {
            if (!file_exists($options['file'])) {
                throw new \InvalidArgumentException(
                    sprintf('The specified file, "%s", does not exist.', $options['file'])
                );
            }

            $data['content'] = file_get_contents($options['file']);
        }

        return $this->client->request(
            'POST',
            "/api/2/$path",
            [
                'body'    => json_encode($data),
                'auth'    => $this->getAuthData(),
                'headers' => ['Content-Type' => 'application/json'],
            ]
        );
    }

    /**
     * Delete a resource within a project.
     *
     * @param string $project  The project the resource is part of
     * @param string $resource The resource slug within the project
     *
     * @return ResponseInterface
     */
    public function deleteResource(string $project, string $resource) : ResponseInterface
    {
        $path = "project/$project/resource/$resource";

        return $this->client->request('DELETE', "/api/2/$path", ['auth' => $this->getAuthData()]);
    }

    /**
     * Get information about a resource within a project.
     *
     * @param string $project  The project the resource is part of
     * @param string $resource The resource slug within the project
     * @param bool   $details  True to retrieve additional project details
     *
     * @return ResponseInterface
     */
    public function getResource(string $project, string $resource, bool $details = false) : ResponseInterface
    {
        $path = "project/$project/resource/$resource/";

        if ($details) {
            $path .= '?details';
        }

        return $this->client->request('GET', "/api/2/$path", ['auth' => $this->getAuthData()]);
    }

    /**
     * Get the content of a resource within a project.
     *
     * @param string $project  The project the resource is part of
     * @param string $resource The resource slug within the project
     *
     * @return ResponseInterface
     */
    public function getResourceContent(string $project, string $resource) : ResponseInterface
    {
        $path = "project/$project/resource/$resource/content/";

        return $this->client->request('GET', "/api/2/$path", ['auth' => $this->getAuthData()]);
    }

    /**
     * Get information about a project's resources.
     *
     * @param string $project The project to retrieve details for
     *
     * @return ResponseInterface
     */
    public function getResources(string $project) : ResponseInterface
    {
        $path = "project/$project/resources";

        return $this->client->request('GET', "/api/2/$path", ['auth' => $this->getAuthData()]);
    }

    /**
     * Update the content of a resource within a project.
     *
     * @param string $project  The project the resource is part of
     * @param string $resource The resource slug within the project
     * @param string $content  The content of the resource.  This can either be a string of data or a file path.
     * @param string $type     The type of content in the $content variable.  This should be either string or file.
     *
     * @return ResponseInterface
     */
    public function updateResourceContent(
        string $project,
        string $resource,
        string $content,
        string $type = 'string'
    ) : ResponseInterface {
        $path = "project/$project/resource/$resource/content/";

        return $this->updateResource($path, $content, $type);
    }
}

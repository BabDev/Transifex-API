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
     */
    public function createResource(
        string $project,
        string $name,
        string $slug,
        string $fileType,
        array $options = []
    ) : ResponseInterface
    {
        // Build the request path.
        $path = "project/$project/resources/";

        // Build the required request data.
        $data = [
            'name'      => $name,
            'slug'      => $slug,
            'i18n_type' => $fileType,
        ];

        // Set the accept translations flag if provided
        if (isset($options['accept_translations'])) {
            $data['accept_translations'] = $options['accept_translations'];
        }

        // Set the resource category if provided
        if (isset($options['category'])) {
            $data['category'] = $options['category'];
        }

        // Set a resource priority if provided
        if (isset($options['priority'])) {
            $data['priority'] = $options['priority'];
        }

        // Attach the resource data if provided as a string
        if (isset($options['content'])) {
            $data['content'] = $options['content'];
        } elseif (isset($options['file'])) {
            $data['content'] = file_get_contents($options['file']);
        }

        return $this->client->post(
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

        return $this->client->delete("/api/2/$path", ['auth' => $this->getAuthData()]);
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

        return $this->client->get("/api/2/$path", ['auth' => $this->getAuthData()]);
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

        return $this->client->get("/api/2/$path", ['auth' => $this->getAuthData()]);
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

        return $this->client->get("/api/2/$path", ['auth' => $this->getAuthData()]);
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
    ) : ResponseInterface
    {
        $path = "project/$project/resource/$resource/content/";

        return $this->updateResource($path, $content, $type);
    }
}

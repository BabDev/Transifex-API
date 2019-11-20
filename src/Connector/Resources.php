<?php declare(strict_types=1);

namespace BabDev\Transifex\Connector;

use BabDev\Transifex\ApiConnector;
use BabDev\Transifex\Exception\InvalidFileTypeException;
use BabDev\Transifex\Exception\MissingFileException;
use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API Resources class.
 *
 * @link http://docs.transifex.com/api/resources/
 */
final class Resources extends ApiConnector
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
     * @throws MissingFileException
     */
    public function createResource(
        string $project,
        string $name,
        string $slug,
        string $fileType,
        array $options = []
    ): ResponseInterface {
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
            if (!\file_exists($options['file'])) {
                throw new MissingFileException(
                    \sprintf('The specified file, "%s", does not exist.', $options['file'])
                );
            }

            $data['content'] = \file_get_contents($options['file']);
        }

        $request = $this->createRequest('POST', $this->createUri("/api/2/project/$project/resources/"));
        $request = $request->withBody($this->streamFactory->createStream(\json_encode($data)));
        $request = $request->withHeader('Content-Type', 'application/json');

        return $this->client->sendRequest($request);
    }

    /**
     * Delete a resource within a project.
     *
     * @param string $project  The slug for the project the resource is part of
     * @param string $resource The resource slug within the project
     *
     * @return ResponseInterface
     */
    public function deleteResource(string $project, string $resource): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('DELETE', $this->createUri("/api/2/project/$project/resource/$resource")));
    }

    /**
     * Get information about a resource within a project.
     *
     * @param string $project  The slug for the project the resource is part of
     * @param string $resource The resource slug within the project
     * @param bool   $details  True to retrieve additional project details
     *
     * @return ResponseInterface
     */
    public function getResource(string $project, string $resource, bool $details = false): ResponseInterface
    {
        $uri = $this->createUri("/api/2/project/$project/resource/$resource/");

        if ($details) {
            $uri = $uri->withQuery('details');
        }

        return $this->client->sendRequest($this->createRequest('GET', $uri));
    }

    /**
     * Get the content of a resource within a project.
     *
     * @param string $project  The slug for the project the resource is part of
     * @param string $resource The resource slug within the project
     *
     * @return ResponseInterface
     */
    public function getResourceContent(string $project, string $resource): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri("/api/2/project/$project/resource/$resource/content/")));
    }

    /**
     * Get information about a project's resources.
     *
     * @param string $project The slug for the project to retrieve details for
     *
     * @return ResponseInterface
     */
    public function getResources(string $project): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri("/api/2/project/$project/resources")));
    }

    /**
     * Update the content of a resource within a project.
     *
     * @param string $project  The slug for the project the resource is part of
     * @param string $resource The resource slug within the project
     * @param string $content  The content of the resource, this can either be a string of data or a file path
     * @param string $type     The type of content in the $content variable, this should be either string or file
     *
     * @return ResponseInterface
     *
     * @throws InvalidFileTypeException
     * @throws MissingFileException
     */
    public function updateResourceContent(
        string $project,
        string $resource,
        string $content,
        string $type = 'string'
    ): ResponseInterface {
        return $this->updateResource($this->createUri("/api/2/project/$project/resource/$resource/content/"), $content, $type);
    }
}

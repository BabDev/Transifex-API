<?php declare(strict_types=1);

namespace BabDev\Transifex\Connector;

use BabDev\Transifex\ApiConnector;
use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API Projects class.
 *
 * @link http://docs.transifex.com/api/projects/
 */
final class Projects extends ApiConnector
{
    /**
     * Build the data array to send with create and update requests.
     *
     * @param array $options Optional additional params to send with the request
     *
     * @return array
     */
    private function buildProjectRequest(array $options): array
    {
        $data = [];

        // Valid options to check
        $validOptions = [
            'long_description',
            'private',
            'homepage',
            'trans_instructions',
            'tags',
            'maintainers',
            'team',
            'auto_join',
            'license',
            'fill_up_resources',
            'repository_url',
            'organization',
            'archived',
            'type',
        ];

        // Loop through the valid options and if we have them, add them to the request data
        foreach ($validOptions as $option) {
            if (isset($options[$option])) {
                $data[$option] = $options[$option];
            }
        }

        // Set the license if present
        if (isset($options['license'])) {
            $this->checkLicense($options['license']);
            $data['license'] = $options['license'];
        }

        return $data;
    }

    /**
     * Checks that a license is an accepted value.
     *
     * @param string $license The license to check
     *
     * @throws \InvalidArgumentException
     */
    private function checkLicense(string $license): void
    {
        $accepted = ['proprietary', 'permissive_open_source', 'other_open_source'];

        // Ensure the license option is an allowed value
        if (!\in_array($license, $accepted)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'The license %s is not valid, accepted license values are %s',
                    $license,
                    \implode(', ', $accepted)
                )
            );
        }
    }

    /**
     * Create a project.
     *
     * @param string $name           The name of the project
     * @param string $slug           The slug for the project
     * @param string $description    A description of the project
     * @param string $sourceLanguage The source language code for the project
     * @param array  $options        Optional additional params to send with the request
     *
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function createProject(
        string $name,
        string $slug,
        string $description,
        string $sourceLanguage,
        array $options = []
    ): ResponseInterface {
        // Build the request data.
        $data = \array_merge(
            [
                'name'                 => $name,
                'slug'                 => $slug,
                'description'          => $description,
                'source_language_code' => $sourceLanguage,
            ],
            $this->buildProjectRequest($options)
        );

        // Check mandatory fields.
        if (!isset($data['license']) || \in_array($data['license'], ['permissive_open_source', 'other_open_source'])) {
            if (!isset($data['repository_url'])) {
                throw new \InvalidArgumentException(
                    'If a project is denoted either as permissive_open_source or other_open_source, the field repository_url is mandatory and should contain a link to the public repository of the project to be created.'
                );
            }
        }

        $request = $this->createRequest('POST', $this->createUri('/api/2/projects/'));
        $request = $request->withBody($this->streamFactory->createStream(\json_encode($data)));
        $request = $request->withHeader('Content-Type', 'application/json');

        return $this->client->sendRequest($request);
    }

    /**
     * Delete a project.
     *
     * @param string $slug The slug for the resource
     *
     * @return ResponseInterface
     */
    public function deleteProject(string $slug): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('DELETE', $this->createUri("/api/2/project/$slug")));
    }

    /**
     * Get a list of projects belonging to an organization.
     *
     * @return ResponseInterface
     */
    public function getOrganizationProjects(string $organization): ResponseInterface
    {
        // This API endpoint uses the newer `api.transifex.com` subdomain, only change if the default www was given
        $currentBaseUri = $this->getOption('base_uri');

        if (!$currentBaseUri || $currentBaseUri === 'https://www.transifex.com') {
            $this->setOption('base_uri', 'https://api.transifex.com');
        }

        try {
            return $this->client->sendRequest($this->createRequest('GET', $this->createUri("/organizations/$organization/projects/")));
        } finally {
            $this->setOption('base_uri', $currentBaseUri);
        }
    }

    /**
     * Get information about a project.
     *
     * @param string $project The project to retrieve details for
     * @param bool   $details True to retrieve additional project details
     *
     * @return ResponseInterface
     */
    public function getProject(string $project, bool $details = false): ResponseInterface
    {
        $uri = $this->createUri("/api/2/project/$project/");

        if ($details) {
            $uri = $uri->withQuery('details');
        }

        return $this->client->sendRequest($this->createRequest('GET', $uri));
    }

    /**
     * Get a list of projects the user is part of.
     *
     * @return ResponseInterface
     */
    public function getProjects(): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri('/api/2/projects/')));
    }

    /**
     * Update a project.
     *
     * @param string $slug    The slug for the project
     * @param array  $options Additional params to send with the request
     *
     * @return ResponseInterface
     *
     * @throws \RuntimeException
     */
    public function updateProject(string $slug, array $options): ResponseInterface
    {
        $data = $this->buildProjectRequest($options);

        // Make sure we actually have data to send
        if (empty($data)) {
            throw new \RuntimeException('There is no data to send to Transifex.');
        }

        $request = $this->createRequest('PUT', $this->createUri("/api/2/project/$slug/"));
        $request = $request->withBody($this->streamFactory->createStream(\json_encode($data)));
        $request = $request->withHeader('Content-Type', 'application/json');

        return $this->client->sendRequest($request);
    }
}

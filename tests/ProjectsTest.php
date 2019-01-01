<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Projects;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Test class for \BabDev\Transifex\Projects.
 */
class ProjectsTest extends TransifexTestCase
{
    /**
     * @testdox createProject() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCreateProject()
    {
        $this->prepareSuccessTest(201);

        // Additional options
        $options = [
            'long_description'   => 'My test project',
            'private'            => true,
            'homepage'           => 'http://www.example.com',
            'trans_instructions' => 'http://www.example.com/instructions.html',
            'tags'               => 'joomla, babdev',
            'maintainers'        => 'joomla',
            'team'               => 'translators',
            'auto_join'          => true,
            'license'            => 'other_open_source',
            'fill_up_resources'  => false,
            'repository_url'     => 'http://www.example.com',
            'organization'       => 'babdev',
            'archived'           => false,
            'type'               => 1,
        ];

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createProject(
            'BabDev Transifex',
            'babdev-transifex',
            'Test Project',
            'en_US',
            $options
        );

        $this->validateSuccessTest('/api/2/projects/', 'POST', 201);
    }

    /**
     * @testdox createProject() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCreateProjectFailureForABadRequest()
    {
        $this->prepareFailureTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createProject(
            'BabDev Transifex',
            'babdev-transifex',
            'Test Project',
            'en_US',
            ['repository_url' => 'https://www.babdev.com']
        );

        $this->validateFailureTest('/api/2/projects/', 'POST');
    }

    /**
     * @testdox createProject() throws an InvalidArgumentException when an invalid license is specified
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateProjectsBadLicense()
    {
        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createProject(
            'BabDev Transifex',
            'babdev-transifex',
            'Test Project',
            'en_US',
            ['license' => 'failure']
        );
    }

    /**
     * @testdox createProject() throws an InvalidArgumentException when required fields are missing
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateProjectFailureForMissingFields()
    {
        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createProject(
            'BabDev Transifex',
            'babdev-transifex',
            'Test Project',
            'en_US'
        );
    }

    /**
     * @testdox deleteProject() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::deleteProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testDeleteProject()
    {
        $this->prepareSuccessTest(204);

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteProject('babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev-transifex', 'DELETE', 204);
    }

    /**
     * @testdox deleteProject() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::deleteProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testDeleteProjectFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteProject('babdev-transifex');

        $this->validateFailureTest('/api/2/project/babdev-transifex', 'DELETE');
    }

    /**
     * @testdox getOrganizationProjects() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::getOrganizationProjects
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetOrganizationProjects()
    {
        $this->prepareSuccessTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getOrganizationProjects('babdev');

        $this->validateSuccessTest('/organizations/babdev/projects/');

        $this->assertSame(
            'api.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API request did not use the new api subdomain.'
        );
    }

    /**
     * @testdox Calling any method after getOrganizationProjects() calls the correct API endpoint
     *
     * @covers  \BabDev\Transifex\Projects::getOrganizationProjects
     * @covers  \BabDev\Transifex\Projects::getProjects
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetOrganizationProjectsThenGetProjects()
    {
        $this->prepareSuccessTest();

        $projects = new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options);

        $projects->getOrganizationProjects('babdev');

        $this->assertSame(
            'api.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API request did not use the new api subdomain.'
        );

        $this->prepareSuccessTest();

        $projects->getProjects();

        $this->assertSame(
            'www.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API request did not switch back to the www subdomain.'
        );
    }

    /**
     * @testdox getOrganizationProjects() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::getOrganizationProjects
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetOrganizationProjectsFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getOrganizationProjects('babdev');

        $this->validateFailureTest('/organizations/babdev/projects/');

        $this->assertSame(
            'api.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API request did not use the new api subdomain.'
        );
    }

    /**
     * @testdox The API URI is reset when an Exception is thrown by getOrganizationProjects()
     *
     * @covers  \BabDev\Transifex\Projects::getOrganizationProjects
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetOrganizationProjectsResetsApiUriOnException()
    {
        $this->client = new class() implements ClientInterface {
            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                throw new class('Testing') extends \RuntimeException implements ClientExceptionInterface {
                };
            }
        };

        $projects = new class($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options) extends Projects {
            public function getBaseUri(): ?string
            {
                return $this->getOption('base_uri');
            }
        };

        try {
            $projects->getOrganizationProjects('babdev');

            $this->fail(\sprintf('A %s should be thrown.', ClientExceptionInterface::class));
        } catch (ClientExceptionInterface $exception) {
            $this->assertSame(
                'https://www.transifex.com',
                $projects->getBaseUri(),
                'The API request did not switch back to the www subdomain.'
            );
        }
    }

    /**
     * @testdox getProject() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProject()
    {
        $this->prepareSuccessTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getProject('babdev-transifex', true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/');

        $this->assertSame(
            'details',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getProject() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProjectFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getProject('babdev-transifex', true);

        $this->validateFailureTest('/api/2/project/babdev-transifex/');
    }

    /**
     * @testdox getProjects() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProjects
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProjects()
    {
        $this->prepareSuccessTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getProjects();

        $this->validateSuccessTest('/api/2/projects/');
    }

    /**
     * @testdox getProjects() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProjects
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProjectsFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getProjects();

        $this->validateFailureTest('/api/2/projects/');
    }

    /**
     * @testdox updateProject() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateProject()
    {
        $this->prepareSuccessTest();

        // Additional options
        $options = [
            'long_description'   => 'My test project',
            'private'            => true,
            'homepage'           => 'http://www.example.com',
            'trans_instructions' => 'http://www.example.com/instructions.html',
            'tags'               => 'joomla, babdev',
            'maintainers'        => 'joomla',
            'team'               => 'translators',
            'auto_join'          => true,
            'license'            => 'other_open_source',
            'fill_up_resources'  => false,
            'repository_url'     => 'http://www.example.com',
            'organization'       => 'babdev',
            'archived'           => false,
            'type'               => 1,
        ];

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateProject('babdev-transifex', $options);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/', 'PUT');
    }

    /**
     * @testdox updateProject() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateProjectFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateProject(
            'babdev-transifex',
            ['long_description' => 'My test project']
        );

        $this->validateFailureTest('/api/2/project/babdev-transifex/', 'PUT');
    }

    /**
     * @testdox updateProject() throws a RuntimeException when there is no data to send to the API
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \RuntimeException
     */
    public function testUpdateProjectRuntimeException()
    {
        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateProject('babdev-transifex', []);
    }

    /**
     * @testdox updateProject() throws an InvalidArgumentException when an invalid license is specified
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateProjectBadLicense()
    {
        (new Projects($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateProject('babdev-transifex', ['license' => 'failure']);
    }
}

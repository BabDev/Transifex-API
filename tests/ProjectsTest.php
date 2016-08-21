<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Projects;

/**
 * Test class for \BabDev\Transifex\Projects.
 */
class ProjectsTest extends TransifexTestCase
{
    /**
     * @testdox createProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
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
            'feed'               => 'http://www.example.com/feed.xml',
            'anyone_submit'      => true,
            'hidden'             => false,
            'bug_tracker'        => 'http://www.example.com/tracker',
            'trans_instructions' => 'http://www.example.com/instructions.html',
            'tags'               => 'joomla, babdev',
            'maintainers'        => 'joomla',
            'outsource'          => 'thirdparty',
            'auto_join'          => true,
            'license'            => 'other_open_source',
            'fill_up_resources'  => false,
            'repository_url'     => 'http://www.example.com',
        ];

        (new Projects($this->options, $this->client))->createProject('BabDev Transifex', 'babdev-transifex',
            'Test Project', 'en_US', $options);

        $this->validateSuccessTest('/api/2/projects/', 'POST', 201);
    }

    /**
     * @testdox createProject() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testCreateProjectFailureForABadRequest()
    {
        $this->prepareFailureTest();

        (new Projects($this->options, $this->client))->createProject('BabDev Transifex', 'babdev-transifex',
            'Test Project', 'en_US', ['repository_url' => 'https://www.babdev.com']);
    }

    /**
     * @testdox createProject() throws an InvalidArgumentException when an invalid license is specified
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateProjectsBadLicense()
    {
        (new Projects($this->options, $this->client))->createProject('BabDev Transifex', 'babdev-transifex',
            'Test Project', 'en_US', ['license' => 'failure']);
    }

    /**
     * @testdox createProject() throws an InvalidArgumentException when required fields are missing
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateProjectFailureForMissingFields()
    {
        (new Projects($this->options, $this->client))->createProject('BabDev Transifex', 'babdev-transifex',
            'Test Project', 'en_US');
    }

    /**
     * @testdox deleteProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::deleteProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testDeleteProject()
    {
        $this->prepareSuccessTest(204);

        (new Projects($this->options, $this->client))->deleteProject('babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev-transifex', 'DELETE', 204);
    }

    /**
     * @testdox deleteProject() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::deleteProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testDeleteProjectFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->options, $this->client))->deleteProject('babdev-transifex');
    }

    /**
     * @testdox getProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProject()
    {
        $this->prepareSuccessTest();

        (new Projects($this->options, $this->client))->getProject('babdev-transifex', true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'details',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getProject() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetProjectFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->options, $this->client))->getProject('babdev-transifex', true);
    }

    /**
     * @testdox getProjects() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProjects
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProjects()
    {
        $this->prepareSuccessTest();

        (new Projects($this->options, $this->client))->getProjects();

        $this->validateSuccessTest('/api/2/projects/');
    }

    /**
     * @testdox getProjects() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProjects
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetProjectsFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->options, $this->client))->getProjects();
    }

    /**
     * @testdox updateProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
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
            'auto_join'          => true,
            'license'            => 'other_open_source',
            'fill_up_resources'  => false,
        ];

        (new Projects($this->options, $this->client))->updateProject('babdev-transifex', $options);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/', 'PUT');
    }

    /**
     * @testdox updateProject() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testUpdateProjectFailure()
    {
        $this->prepareFailureTest();

        (new Projects($this->options, $this->client))->updateProject('babdev-transifex',
            ['long_description' => 'My test project']);
    }

    /**
     * @testdox updateProject() throws a RuntimeException when there is no data to send to the API
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \RuntimeException
     */
    public function testUpdateProjectRuntimeException()
    {
        (new Projects($this->options, $this->client))->updateProject('babdev-transifex', []);
    }

    /**
     * @testdox updateProject() throws an InvalidArgumentException when an invalid license is specified
     *
     * @covers  \BabDev\Transifex\Projects::buildProjectRequest
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateProjectBadLicense()
    {
        (new Projects($this->options, $this->client))->updateProject('babdev-transifex', ['license' => 'failure']);
    }
}

<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex\tests;

use BabDev\Transifex\Projects;

/**
 * Test class for \BabDev\Transifex\Projects.
 */
class ProjectsTest extends TransifexTestCase
{
    /**
     * @var Projects
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Projects($this->options, $this->client);
    }

    /**
     * @testdox createProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCreateProject()
    {
        $this->prepareSuccessTest('post', '/projects/', 201);

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

        $this->assertSame(
            $this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform',
                'en_GB', $options),
            $this->response
        );
    }

    /**
     * @testdox createProject() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testCreateProjectFailureForABadRequest()
    {
        $this->prepareFailureTest('post', '/projects/');

        $this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB',
            ['repository_url' => 'http://www.joomla.org']);
    }

    /**
     * @testdox createProject() throws an InvalidArgumentException when an invalid license is specified
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateProjectsBadLicense()
    {
        $this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB',
            ['license' => 'failure']);
    }

    /**
     * @testdox createProject() throws an InvalidArgumentException when required fields are missing
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::createProject
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateProjectFailureForMissingFields()
    {
        $this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB');
    }

    /**
     * @testdox deleteProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::deleteProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testDeleteProject()
    {
        $this->prepareSuccessTest('delete', '/project/joomla-platform', 204);

        $this->assertSame(
            $this->object->deleteProject('joomla-platform'),
            $this->response
        );
    }

    /**
     * @testdox deleteProject() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::deleteProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testDeleteProjectFailure()
    {
        $this->prepareFailureTest('delete', '/project/joomla-platform');

        $this->object->deleteProject('joomla-platform');
    }

    /**
     * @testdox getProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProject()
    {
        $this->prepareSuccessTest('get', '/project/joomla-platform/?details');

        $this->assertSame(
            $this->object->getProject('joomla-platform', true),
            $this->response
        );
    }

    /**
     * @testdox getProject() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetProjectFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla-platform/?details');

        $this->object->getProject('joomla-platform', true);
    }

    /**
     * @testdox getProjects() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProjects
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetProjects()
    {
        $this->prepareSuccessTest('get', '/projects/');

        $this->assertSame(
            $this->object->getProjects(),
            $this->response
        );
    }

    /**
     * @testdox getProjects() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::getProjects
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetProjectsFailure()
    {
        $this->prepareFailureTest('get', '/projects/');

        $this->object->getProjects();
    }

    /**
     * @testdox updateProject() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateProject()
    {
        $this->prepareSuccessTest('put', '/project/joomla-platform/');

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

        $this->assertSame(
            $this->object->updateProject('joomla-platform', $options),
            $this->response
        );
    }

    /**
     * @testdox updateProject() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testUpdateProjectFailure()
    {
        $this->prepareFailureTest('put', '/project/joomla-platform/');

        $this->object->updateProject('joomla-platform', ['long_description' => 'My test project']);
    }

    /**
     * @testdox updateProject() throws a RuntimeException when there is no data to send to the API
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \RuntimeException
     */
    public function testUpdateProjectRuntimeException()
    {
        $this->object->updateProject('joomla-platform');
    }

    /**
     * @testdox updateProject() throws an InvalidArgumentException when an invalid license is specified
     *
     * @covers  \BabDev\Transifex\Projects::checkLicense
     * @covers  \BabDev\Transifex\Projects::updateProject
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateProjectBadLicense()
    {
        $this->object->updateProject('joomla-platform', ['license' => 'failure']);
    }
}

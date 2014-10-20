<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Projects;

/**
 * Test class for \BabDev\Transifex\Projects.
 *
 * @since  1.0
 */
class ProjectsTest extends TransifexTestCase
{
	/**
	 * @var    Projects  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Projects($this->options, $this->client);
	}

	/**
	 * Tests the createProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
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
		$options = array(
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
			'repository_url'     => 'http://www.example.com'
	);

		$this->assertEquals(
			$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::createProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateProjectFailureForABadRequest()
	{
		$this->prepareFailureTest('post', '/projects/');

		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', array('repository_url' => 'http://www.joomla.org'));
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::createProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateProjectsBadLicense()
	{
		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', array('license' => 'failure'));
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::createProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateProjectFailureForMissingFields()
	{
		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB');
	}

	/**
	 * Tests the deleteProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::deleteProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteProject()
	{
		$this->prepareSuccessTest('delete', '/project/joomla-platform', 204);

		$this->assertEquals(
			$this->object->deleteProject('joomla-platform'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the deleteProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::deleteProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteProjectFailure()
	{
		$this->prepareFailureTest('delete', '/project/joomla-platform');

		$this->object->deleteProject('joomla-platform');
	}

	/**
	 * Tests the getProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProject()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/?details');

		$this->assertEquals(
			$this->object->getProject('joomla-platform', true),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProjectFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla-platform/?details');

		$this->object->getProject('joomla-platform', true);
	}

	/**
	 * Tests the getProjects method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProjects
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProjects()
	{
		$this->prepareSuccessTest('get', '/projects/');

		$this->assertEquals(
			$this->object->getProjects(),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getProjects method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProjects
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProjectsFailure()
	{
		$this->prepareFailureTest('get', '/projects/');

		$this->object->getProjects();
	}

	/**
	 * Tests the updateProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
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
		$options = array(
			'long_description'   => 'My test project',
		    'private'            => true,
		    'homepage'           => 'http://www.example.com',
		    'trans_instructions' => 'http://www.example.com/instructions.html',
		    'tags'               => 'joomla, babdev',
		    'maintainers'        => 'joomla',
		    'auto_join'          => true,
		    'license'            => 'other_open_source',
		    'fill_up_resources'  => false
		);

		$this->assertEquals(
			$this->object->updateProject('joomla-platform', $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::updateProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateProjectFailure()
	{
		$this->prepareFailureTest('put', '/project/joomla-platform/');

		$this->object->updateProject('joomla-platform', array('long_description' => 'My test project'));
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \RuntimeException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::updateProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateProjectRuntimeException()
	{
		$this->object->updateProject('joomla-platform');
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::updateProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateProjectBadLicense()
	{
		$this->object->updateProject('joomla-platform', array('license' => 'failure'));
	}
}

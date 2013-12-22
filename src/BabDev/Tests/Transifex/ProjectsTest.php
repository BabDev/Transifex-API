<?php
/**
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Tests\Transifex;

use BabDev\Http\Response;
use BabDev\Transifex\Http;
use BabDev\Transifex\Projects;

use Joomla\Registry\Registry;

/**
 * Test class for \BabDev\Transifex\Projects.
 *
 * @since  1.0
 */
class ProjectsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    Registry  Options for the GitHub object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    Http  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    Response  Mock response object.
	 * @since  1.0
	 */
	protected $response;

	/**
	 * @var    Projects  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  1.0
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  1.0
	 */
	protected $errorString = '{"message": "Generic Error"}';

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
		$this->options = new Registry;
		$this->client = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('\\BabDev\\Http\\Response');

		$this->object = new Projects($this->options, $this->client);
	}

	/**
	 * Tests the createProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testCreateProject()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('post')
			->with('/projects/')
			->will($this->returnValue($this->response));

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
		    'fill_up_resources'  => false
		);

		$this->assertThat(
			$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', $options),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testCreateProjectFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('post')
			->with('/projects/')
			->will($this->returnValue($this->response));

		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB');
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 */
	public function testCreateProjectsBadLicense()
	{
		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', array('license' => 'failure'));
	}

	/**
	 * Tests the deleteProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testDeleteProject()
	{
		$this->response->code = 204;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->deleteProject('joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the deleteProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testDeleteProjectFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform')
			->will($this->returnValue($this->response));

		$this->object->deleteProject('joomla-platform');
	}

	/**
	 * Tests the getProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetProject()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/?details')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getProject('joomla-platform', true),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testGetProjectFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/?details')
			->will($this->returnValue($this->response));

		$this->object->getProject('joomla-platform', true);
	}

	/**
	 * Tests the getProjects method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetProjects()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/projects/')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getProjects(),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getProjects method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testGetProjectsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/projects/')
			->will($this->returnValue($this->response));

		$this->object->getProjects();
	}

	/**
	 * Tests the updateProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testUpdateProject()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/')
			->will($this->returnValue($this->response));

		// Additional options
		$options = array(
			'name'               => 'Joomla Platform',
			'description'        => 'Project for the Joomla Platform',
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
		    'fill_up_resources'  => false
		);

		$this->assertThat(
			$this->object->updateProject('joomla-platform', $options),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testUpdateProjectsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/')
			->will($this->returnValue($this->response));

		$this->object->updateProject('joomla-platform', array('name' => 'Joomla Platform'));
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \RuntimeException
	 * @since              1.0
	 */
	public function testUpdateProjectsRuntimeException()
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
	 */
	public function testUpdateProjectsBadLicense()
	{
		$this->object->updateProject('joomla-platform', array('license' => 'failure'));
	}
}

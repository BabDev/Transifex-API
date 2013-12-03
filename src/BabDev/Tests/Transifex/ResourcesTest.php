<?php
/**
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Tests\Transifex;

use BabDev\Http\Response;
use BabDev\Transifex\Http;
use BabDev\Transifex\Resources;

use Joomla\Registry\Registry;

/**
 * Test class for \BabDev\Transifex\Resources.
 *
 * @since  1.0
 */
class ResourcesTest extends \PHPUnit_Framework_TestCase
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
	 * @var    Resources  Object under test.
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

		$this->object = new Resources($this->options, $this->client);
	}

	/**
	 * Tests the createResource method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testCreateResource()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('post')
			->with('/project/joomla-platform/resources/')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->createResource('joomla-platform', 'joomla-platform', 'INI', array('content' => 'Test="Test"')),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the createResource method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testCreateResourceFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('post')
			->with('/project/joomla-platform/resources/')
			->will($this->returnValue($this->response));

		$this->object->createResource('joomla-platform', 'joomla-platform', 'INI', array('content' => 'Test="Test"'));
	}

	/**
	 * Tests the deleteResource method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testDeleteResource()
	{
		$this->response->code = 204;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla/resource/joomla-platform')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->deleteResource('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the deleteResource method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testDeleteResourceFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla/resource/joomla-platform')
			->will($this->returnValue($this->response));

		$this->object->deleteResource('joomla', 'joomla-platform');
	}

	/**
	 * Tests the getResource method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetResource()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/?details')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getResource('joomla', 'joomla-platform', true),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getResource method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testGetResourceFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/?details')
			->will($this->returnValue($this->response));

		$this->object->getResource('joomla', 'joomla-platform', true);
	}

	/**
	 * Tests the getResourceContent method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetResourceContent()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/content/')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getResourceContent('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getResourceContent method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testGetResourceContentFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/content/')
			->will($this->returnValue($this->response));

		$this->object->getResourceContent('joomla', 'joomla-platform');
	}

	/**
	 * Tests the getResources method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetResources()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resources')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getResources('joomla'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getResources method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testGetResourcesFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resources')
			->will($this->returnValue($this->response));

		$this->object->getResources('joomla');
	}
}

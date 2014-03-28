<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Http\Response;
use BabDev\Transifex\Http;
use BabDev\Transifex\Resources;

/**
 * Test class for \BabDev\Transifex\Resources.
 *
 * @note   Do not set the error object message here to test TransifexObject handling
 * @since  1.0
 */
class ResourcesTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the GitHub object.
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
	protected $errorString = '{}';

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
		$this->options = array();
		$this->client = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('\\BabDev\\Http\\Response');

		$this->object = new Resources($this->options, $this->client);
	}

	/**
	 * Tests the createResource method with inline content
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testCreateResourceContent()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('post')
			->with('/project/joomla-platform/resources/')
			->will($this->returnValue($this->response));

		// Additional options
		$options = array(
		    'accept_translations' => true,
		    'category'            => 'whatever',
		    'priority'            => 3,
		    'content'             => 'Test="Test"'
		);

		$this->assertEquals(
			$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the createResource method with an attached file
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testCreateResourceFile()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('post')
			->with('/project/joomla-platform/resources/')
			->will($this->returnValue($this->response));

		// Additional options
		$options = array(
		    'accept_translations' => true,
		    'category'            => 'whatever',
		    'priority'            => 3,
		    'file'                => __DIR__ . '/stubs/source.ini'
		);

		$this->assertEquals(
			$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', $options),
			json_decode($this->sampleString)
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

		$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', array('content' => 'Test="Test"'));
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

		$this->assertEquals(
			$this->object->deleteResource('joomla', 'joomla-platform'),
			json_decode($this->sampleString)
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

		$this->assertEquals(
			$this->object->getResource('joomla', 'joomla-platform', true),
			json_decode($this->sampleString)
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

		$this->assertEquals(
			$this->object->getResourceContent('joomla', 'joomla-platform'),
			json_decode($this->sampleString)
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

		$this->assertEquals(
			$this->object->getResources('joomla'),
			json_decode($this->sampleString)
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

	/**
	 * Tests the updateResourceContent method with the content sent as a file
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testUpdateResourceContentFile()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla/resource/joomla-platform/content/')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->updateResourceContent('joomla', 'joomla-platform', __DIR__ . '/stubs/source.ini', 'file'),
			json_decode($this->sampleString)
		);
	}


	/**
	 * Tests the updateResourceContent method with the content sent as a string
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testUpdateResourceContentString()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla/resource/joomla-platform/content/')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateResourceContent method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testUpdateResourceContentFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla/resource/joomla-platform/content/')
			->will($this->returnValue($this->response));

		$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"');
	}

	/**
	 * Tests the updateResourceContent method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 */
	public function testUpdateResourceContentBadType()
	{
		$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"', 'stuff');
	}
}

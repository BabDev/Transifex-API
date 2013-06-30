<?php
/**
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for BDTransifexResources.
 *
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexResourcesTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var    JRegistry  Options for the GitHub object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    BDTransifexHttp  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    BDHttpResponse  Mock response object.
	 * @since  1.0
	 */
	protected $response;

	/**
	 * @var    BDTransifexResources  Object under test.
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
		$this->options = new JRegistry;
		$this->client = $this->getMock('BDTransifexHttp', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('BDHttpResponse');

		$this->object = new BDTransifexResources($this->options, $this->client);
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
	 * @expectedException  DomainException
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
	 * @expectedException  DomainException
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
	 * @expectedException  DomainException
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

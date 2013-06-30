<?php
/**
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for BDTransifexStatistics.
 *
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexTranslationsTest extends PHPUnit_Framework_TestCase
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
	 * @var    BDTransifexTranslations  Object under test.
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

		$this->object = new BDTransifexTranslations($this->options, $this->client);
	}

	/**
	 * Tests the getTranslation method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetStatistics()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getTranslation('joomla', 'joomla-platform', 'en_GB'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getTranslation method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  DomainException
	 * @since              1.0
	 */
	public function testGetStatisticsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB')
			->will($this->returnValue($this->response));

		$this->object->getTranslation('joomla', 'joomla-platform', 'en_GB');
	}
}

<?php
/**
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Tests\Transifex;

use BabDev\Http\Response;
use BabDev\Transifex\Http;
use BabDev\Transifex\Translationstrings;

use Joomla\Registry\Registry;

/**
 * Test class for \BabDev\Transifex\Translationstrings.
 *
 * @since  1.0
 */
class TranslationstringsTest extends \PHPUnit_Framework_TestCase
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
	 * @var    Translationstrings  Object under test.
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

		$this->object = new Translationstrings($this->options, $this->client);
	}

	/**
	 * Tests the getStrings method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetStrings()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getStrings method - Query for details
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetStringsDetails()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getStrings method - Query for details and key
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetStringsDetailsKey()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details\&key=Yes')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true, array('key' => 'Yes')),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getStrings method - Query for details, key, and context
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetStringsDetailsKeyContext()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details\&key=Yes\&context=Something')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true, array('key' => 'Yes', 'context' => 'Something')),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getStrings method - Query for key, and context
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetStringsKeyContext()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?key=Yes\&context=Something')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', false, array('key' => 'Yes', 'context' => 'Something')),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getStrings method - Query for context
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetStringsContext()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?context=Something')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', false, array('context' => 'Something')),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getStrings method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 */
	public function testGetStringsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/')
			->will($this->returnValue($this->response));

		$this->object->getStrings('joomla', 'joomla-platform', 'en_GB');
	}
}

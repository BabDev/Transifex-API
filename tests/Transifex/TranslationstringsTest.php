<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Translationstrings;

/**
 * Test class for \BabDev\Transifex\Translationstrings.
 *
 * @since  1.0
 */
class TranslationstringsTest extends TransifexTestCase
{
	/**
	 * @var    Translationstrings  Object under test.
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

		$this->object = new Translationstrings($this->options, $this->client);
	}

	/**
	 * Tests the getStrings method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translationstrings::getStrings
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStrings()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getStrings method - Query for details
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translationstrings::getStrings
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStringsDetails()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getStrings method - Query for details and key
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translationstrings::getStrings
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStringsDetailsKey()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details\&key=Yes')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true, array('key' => 'Yes')),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getStrings method - Query for details, key, and context
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translationstrings::getStrings
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStringsDetailsKeyContext()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details\&key=Yes\&context=Something')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true, array('key' => 'Yes', 'context' => 'Something')),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getStrings method - Query for key, and context
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translationstrings::getStrings
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStringsKeyContext()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?key=Yes\&context=Something')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', false, array('key' => 'Yes', 'context' => 'Something')),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getStrings method - Query for context
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translationstrings::getStrings
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStringsContext()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB/strings/?context=Something')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getStrings('joomla', 'joomla-platform', 'en_GB', false, array('context' => 'Something')),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getStrings method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translationstrings::getStrings
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
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

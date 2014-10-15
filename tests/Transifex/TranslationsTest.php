<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use Joomla\Http\Response;
use BabDev\Transifex\Http;
use BabDev\Transifex\Translations;

/**
 * Test class for \BabDev\Transifex\Translations.
 *
 * @since  1.0
 */
class TranslationsTest extends \PHPUnit_Framework_TestCase
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
	 * @var    Translations  Object under test.
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
		$this->options = array();
		$this->client = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('\\Joomla\\Http\\Response');

		$this->object = new Translations($this->options, $this->client);
	}

	/**
	 * Tests the getTranslation method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translations::getTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslation()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getTranslation('joomla', 'joomla-platform', 'en_GB'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getTranslation method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translations::getTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslationFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB')
			->will($this->returnValue($this->response));

		$this->object->getTranslation('joomla', 'joomla-platform', 'en_GB');
	}

	/**
	 * Tests the updateTranslation method with the content sent as a file
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationFile()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', __DIR__ . '/stubs/source.ini', 'file'),
			json_decode($this->sampleString)
		);
	}


	/**
	 * Tests the updateTranslation method with the content sent as a string
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationString()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateTranslation method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla/resource/joomla-platform/translation/en_GB')
			->will($this->returnValue($this->response));

		$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"');
	}

	/**
	 * Tests the updateTranslation method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationBadType()
	{
		$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"', 'stuff');
	}
}

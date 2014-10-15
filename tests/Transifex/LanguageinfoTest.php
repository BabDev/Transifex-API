<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Http;
use BabDev\Transifex\Languageinfo;

use Joomla\Http\Response;

/**
 * Test class for \BabDev\Transifex\Languageinfo.
 *
 * @since  1.0
 */
class LanguageinfoTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the Languageinfo object.
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
	 * @var    LanguageInfo  Object under test.
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

		$this->object = new Languageinfo($this->options, $this->client);
	}

	/**
	 * Tests the getLanguage method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languageinfo::getLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguage()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/language/en_GB/')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getLanguage('en_GB'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Languageinfo::getLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguageFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/language/en_GB/')
			->will($this->returnValue($this->response));

		$this->object->getLanguage('en_GB');
	}

	/**
	 * Tests the getLanguages method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languageinfo::getLanguages
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguages()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/languages/')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getLanguages(),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getLanguages method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Languageinfo::getLanguages
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguagesFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/languages/')
			->will($this->returnValue($this->response));

		$this->object->getLanguages();
	}
}

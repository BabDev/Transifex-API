<?php
/**
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Http;
use BabDev\Transifex\Transifex;

/**
 * Test class for \BabDev\Transifex\Transifex.
 *
 * @since  1.0
 */
class TransifexTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the Transifex object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    Http  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    Transifex  Object being tested
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
		$this->options = array('api.username' => 'test', 'api.password' => 'test');
		$this->client  = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->object  = new Transifex($this->options, $this->client);
	}

	/**
	 * Tests the constructor for building a proper Transifex instance without the client injected
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Transifex::__construct
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\Transifex::getOption
	 * @uses    \BabDev\Transifex\Transifex::setOption
	 */
	public function test__constructWithNoInjectedClient()
	{
		$object = new Transifex($this->options);

		$this->assertInstanceOf(
			'\\BabDev\\Transifex\\Transifex',
			$object,
			'The object successfully is created without a client injected.'
		);

		$this->assertAttributeInstanceOf(
			'\\Joomla\\Http\\Http',
			'client',
			$object,
			'Ensure the Transifex object has a HTTP client instance.'
		);
	}

	/**
	 * Tests the magic __get method - Non-existing object
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Transifex::__get
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\Transifex::__construct
	 * @uses    \BabDev\Transifex\Transifex::getOption
	 * @uses    \BabDev\Transifex\Transifex::setOption
	 */
	public function test__GetFake()
	{
		$object = $this->object->fake;
	}

	/**
	 * Tests the magic __get method - Formats object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetFormats()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Formats',
			$this->object->formats
		);
	}

	/**
	 * Tests the magic __get method - Languageinfo object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetLanguageinfo()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Languageinfo',
			$this->object->languageinfo
		);
	}

	/**
	 * Tests the magic __get method - Languages object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetLanguages()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Languages',
			$this->object->languages
		);
	}

	/**
	 * Tests the magic __get method - Projects object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetProjects()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Projects',
			$this->object->projects
		);
	}

	/**
	 * Tests the magic __get method - Resources object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetResources()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Resources',
			$this->object->resources
		);
	}

	/**
	 * Tests the magic __get method - Statistics object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetStatistics()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Statistics',
			$this->object->statistics
		);
	}

	/**
	 * Tests the magic __get method - Translations object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetTranslations()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Translations',
			$this->object->translations
		);
	}

	/**
	 * Tests the magic __get method - Translationstrings object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetTranslationstrings()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Translationstrings',
			$this->object->translationstrings
		);
	}

	/**
	 * Tests the setOption and getOption methods
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testSetAndGetOption()
	{
		$this->object->setOption('api.url', 'https://example.com/test');

		$this->assertAttributeContains('https://example.com/test', 'options', $this->object);

		$this->assertSame(
			$this->object->getOption('api.url'),
			'https://example.com/test'
		);
	}
}

<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Http;
use BabDev\Transifex\Transifex;

use Joomla\Test\TestHelper;

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
		$this->options = array();
		$this->client = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));

		$this->object = new Transifex($this->options, $this->client);
	}

	/**
	 * Tests the magic __get method - Non-existing object
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 * Tests the magic __get method - Releases object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__GetReleases()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Releases',
			$this->object->releases
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
	 * Tests the setOption method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testSetOption()
	{
		$this->object->setOption('api.url', 'https://example.com/settest');

		$value = TestHelper::getValue($this->object, 'options');

		$this->assertEquals(
			$value['api.url'],
			'https://example.com/settest'
		);
	}

	/**
	 * Tests the getOption method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetOption()
	{
		TestHelper::setValue(
			$this->object, 'options', array(
				'api.url' => 'https://example.com/gettest'
			)
		);

		$this->assertEquals(
			$this->object->getOption('api.url'),
			'https://example.com/gettest'
		);
	}
}

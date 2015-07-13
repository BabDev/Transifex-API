<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Transifex;

/**
 * Test class for \BabDev\Transifex\Transifex.
 */
class TransifexTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Mock HTTP client object.
	 *
	 * @var  \PHPUnit_Framework_MockObject_MockObject
	 */
	private $client;

	/**
	 * Object being tested.
	 *
	 * @var  Transifex
	 */
	private $object;

	/**
	 * Options for the Transifex object.
	 *
	 * @var  array
	 */
	private $options;

	/**
	 * {@inheritdoc}
	 */
	protected function setUp()
	{
		$this->options = array('api.username' => 'test', 'api.password' => 'test');
		$this->client  = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->object  = new Transifex($this->options, $this->client);
	}

	/**
	 * @testdox  __construct() with no injected client creates a Transifex instance with a default Http object
	 *
	 * @covers  \BabDev\Transifex\Transifex::__construct
	 * @covers  \BabDev\Transifex\Http::__construct
	 * @uses    \BabDev\Transifex\Transifex::getOption
	 * @uses    \BabDev\Transifex\Transifex::setOption
	 */
	public function test__constructWithNoInjectedClient()
	{
		$object = new Transifex($this->options);

		$this->assertInstanceOf(
			'\\BabDev\\Transifex\\Transifex',
			$object
		);

		$this->assertAttributeInstanceOf(
			'\\BabDev\\Transifex\\Http',
			'client',
			$object
		);
	}

	/**
	 * @testdox  get() throws an InvalidArgumentException for a non-existing object
	 *
	 * @expectedException  \InvalidArgumentException
	 *
	 * @covers  \BabDev\Transifex\Transifex::get
	 * @uses    \BabDev\Transifex\Transifex::getOption
	 */
	public function testGetFake()
	{
		$this->object->get('fake');
	}

	/**
	 * @testdox  get() with the "formats" parameter returns an instance of the Formats object
	 *
	 * @covers  \BabDev\Transifex\Transifex::get
	 * @uses    \BabDev\Transifex\Formats
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\Transifex::__construct
	 * @uses    \BabDev\Transifex\Transifex::getOption
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetFormats()
	{
		$this->assertInstanceOf(
		     '\\BabDev\\Transifex\\Formats',
			$this->object->get('formats')
		);
	}

	/**
	 * @testdox  get() with a custom namespace defined and the "formats" parameter returns an instance of the custom Formats object
	 *
	 * @covers  \BabDev\Transifex\Transifex::get
	 * @uses    \BabDev\Transifex\Formats
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\Transifex::__construct
	 * @uses    \BabDev\Transifex\Transifex::getOption
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetFormatsInCustomNamespace()
	{
		$this->object->setOption('object.namespace', 'BabDev\\Transifex\\Tests\\Mock');

		$this->assertInstanceOf(
			'\\BabDev\\Transifex\\Tests\\Mock\\Formats',
			$this->object->get('formats')
		);
	}

	/**
	 * @testdox  get() with a custom namespace defined and the "formats" parameter and a class not found in the custom namespace returns an instance of the default Formats object
	 *
	 * @covers  \BabDev\Transifex\Transifex::get
	 * @uses    \BabDev\Transifex\Formats
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\Transifex::__construct
	 * @uses    \BabDev\Transifex\Transifex::getOption
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetFormatsInCustomNamespaceWhenNotFound()
	{
		$this->object->setOption('object.namespace', 'BabDev\\Transifex\\Tests');

		$this->assertInstanceOf(
			'\\BabDev\\Transifex\\Formats',
			$this->object->get('formats')
		);
	}

	/**
	 * @testdox  getOption() and setOption() correctly manage the object's options
	 *
	 * @covers  \BabDev\Transifex\Transifex::getOption
	 * @covers  \BabDev\Transifex\Transifex::setOption
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\Transifex::__construct
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

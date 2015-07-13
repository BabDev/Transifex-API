<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use Joomla\Test\TestHelper;

/**
 * Test class for \BabDev\Transifex\TransifexObject.
 */
class TransifexObjectTest extends \PHPUnit_Framework_TestCase
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
	 * @var  TransifexObject
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
		$this->options = array(
			'api.url'      => 'http://www.transifex.com/api/2',
		    'api.username' => 'MyTestUser',
		    'api.password' => 'MyTestPass'
		);
		$this->client  = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->object  = $this->getMockForAbstractClass('\\BabDev\\Transifex\\TransifexObject', array($this->options, $this->client));
	}

	/**
	 * @testdox  __construct() with no injected client creates a Transifex instance with a default Http object
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::__construct
	 * @covers  \BabDev\Transifex\Http::__construct
	 */
	public function test__constructWithNoInjectedClient()
	{
		$object = $this->getMockForAbstractClass('\\BabDev\\Transifex\\TransifexObject', array($this->options));

		$this->assertInstanceOf(
			'\\BabDev\\Transifex\\TransifexObject',
			$object
		);

		$this->assertAttributeInstanceOf(
			'\\BabDev\\Transifex\\Http',
			'client',
			$object
		);
	}

	/**
	 * @testdox  fetchUrl() returns the full API URL
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::fetchUrl
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject::__construct
	 */
	public function testFetchUrlBasicAuth()
	{
		// Use Reflection to trigger fetchUrl()
		$this->assertSame(
			TestHelper::invoke($this->object, 'fetchUrl', '/formats'),
			'http://www.transifex.com/api/2/formats'
		);
	}
}

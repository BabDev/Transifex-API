<?php
/**
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Http;

use Joomla\Registry\Registry;

/**
 * Test class for BDTransifex.
 *
 * @since  1.0
 */
class TransifexObjectTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    Registry  Options for the Transifex object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    Http  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    ObjectMock  Object being tested
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
		$this->options = new Registry;
		$this->client = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));

		$this->object = $this->getMockForAbstractClass('\\BabDev\\Transifex\\TransifexObject', array($this->options, $this->client));
	}

	/**
	 * Tests the fetchUrl method with basic authentication data
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testFetchUrlBasicAuth()
	{
		$this->options->set('api.url', 'http://www.transifex.com/api/2');

		$this->options->set('api.username', 'MyTestUser');
		$this->options->set('api.password', 'MyTestPass');

		// Use Reflection to trigger fetchUrl()
		$method = new \ReflectionMethod($this->object, 'fetchUrl');
		$method->setAccessible(true);

		$result = $method->invokeArgs($this->object, array('/formats'));

		$this->assertEquals(
			$result,
			'http://www.transifex.com/api/2/formats'
		);
	}
}

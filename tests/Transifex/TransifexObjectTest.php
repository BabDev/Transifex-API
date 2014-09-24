<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Http;

use Joomla\Test\TestHelper;

/**
 * Test class for \BabDev\Transifex\TransifexObject.
 *
 * @since  1.0
 */
class TransifexObjectTest extends \PHPUnit_Framework_TestCase
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
	 * @var    \BabDev\Transifex\TransifexObject  Object being tested
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

		$this->object = $this->getMockForAbstractClass('\\BabDev\\Transifex\\TransifexObject', array($this->options, $this->client));
	}

	/**
	 * Tests the constructor for building a proper TransifexObject instance without the client injected
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__constructWithNoInjectedClient()
	{
		$object = $this->getMockForAbstractClass('\\BabDev\\Transifex\\TransifexObject', array($this->options));

		$this->assertInstanceOf(
			'\\BabDev\\Transifex\\TransifexObject',
			$object,
			'The object successfully is created without a client injected.'
		);

		$this->assertInstanceOf(
			'\\Joomla\\Http\\Http',
			TestHelper::getValue($object, 'client'),
			'Ensure the TransifexObject has a HTTP client instance.'
		);
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
		$this->options['api.url'] = 'http://www.transifex.com/api/2';
		$this->options['api.username'] = 'MyTestUser';
		$this->options['api.password'] = 'MyTestPass';

		// Set the options array to the object
		TestHelper::setValue($this->object, 'options', $this->options);

		// Use Reflection to trigger fetchUrl()
		$result = TestHelper::invoke($this->object, 'fetchUrl', '/formats');

		$this->assertEquals(
			$result,
			'http://www.transifex.com/api/2/formats'
		);
	}
}

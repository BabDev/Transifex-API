<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Http;

use BabDev\Http\Http;
use BabDev\Http\Transport\Curl;

use Joomla\Test\TestHelper;
use Joomla\Uri\Uri;

/**
 * Test class for \BabDev\Http\Http classes.
 *
 * @since  1.0
 */
class HttpTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the BDHttp object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    Curl  Mock transport object.
	 * @since  1.0
	 */
	protected $transport;

	/**
	 * @var    Http  Object under test.
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
		static $classNumber = 1;
		$this->options = array();
		$this->transport = $this->getMock('\\BabDev\\Http\\Transport\\Curl', array('request'), array($this->options), 'CustomTransport' . $classNumber ++, false);

		$this->object = new Http($this->options, $this->transport);
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
				'testKey' => 'testValue'
			)
		);

		$this->assertThat(
			$this->object->getOption('testKey'),
			$this->equalTo('testValue')
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
		$this->object->setOption('testKey', 'testValue');

		$value = TestHelper::getValue($this->object, 'options');

		$this->assertThat(
			$value['testKey'],
			$this->equalTo('testValue')
		);
	}

	/**
	 * Tests the options method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testOptions()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('OPTIONS', new Uri('http://example.com'), null, array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->options('http://example.com', array('testHeader')),
			'ReturnString'
		);
	}

	/**
	 * Tests the head method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testHead()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('HEAD', new Uri('http://example.com'), null, array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->head('http://example.com', array('testHeader')),
			'ReturnString'
		);
	}

	/**
	 * Tests the get method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGet()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('GET', new Uri('http://example.com'), null, array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->get('http://example.com', array('testHeader')),
			'ReturnString'
		);
	}

	/**
	 * Tests the post method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testPost()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('POST', new Uri('http://example.com'), array('key' => 'value'), array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->post('http://example.com', array('key' => 'value'), array('testHeader')),
			'ReturnString'
		);
	}

	/**
	 * Tests the put method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testPut()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('PUT', new Uri('http://example.com'), array('key' => 'value'), array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->put('http://example.com', array('key' => 'value'), array('testHeader')),
			'ReturnString'
		);
	}

	/**
	 * Tests the delete method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testDelete()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('DELETE', new Uri('http://example.com'), null, array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->delete('http://example.com', array('testHeader')),
			'ReturnString'
		);
	}

	/**
	 * Tests the trace method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testTrace()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('TRACE', new Uri('http://example.com'), null, array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->trace('http://example.com', array('testHeader')),
			'ReturnString'
		);
	}

	/**
	 * Tests the patch method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testPatch()
	{
		$this->transport->expects($this->once())
			->method('request')
			->with('PATCH', new Uri('http://example.com'), array('key' => 'value'), array('testHeader'))
			->will($this->returnValue('ReturnString'));

		$this->assertEquals(
			$this->object->patch('http://example.com', array('key' => 'value'), array('testHeader')),
			'ReturnString'
		);
	}
}

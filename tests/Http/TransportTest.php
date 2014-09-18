<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Http;

use Joomla\Uri\Uri;

/**
 * Test class for \BabDev\Http\TransportInterface classes.
 *
 * @since  1.0
 */
class TransportTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the BDHttpTransport object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    string  The URL string for the HTTP stub.
	 * @since  1.0
	 */
	protected $stubUrl;

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
		$this->options = array(
			'api.username'       => 'testUser',
		    'api.password'       => 'testPassword',
		    'api.authentication' => 'HTTP'
		);

		if (!defined('BDTEST_HTTP_STUB') && getenv('BDTEST_HTTP_STUB') == '')
		{
			$this->markTestSkipped('The TransportInterface test stub has not been configured');
		}
		else
		{
			$this->stubUrl = defined('BDTEST_HTTP_STUB') ? BDTEST_HTTP_STUB : getenv('BDTEST_HTTP_STUB');
		}
	}

	/**
	 * Data provider for the request test methods.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function transportProvider()
	{
		return array(
			'stream' => array('\\BabDev\\Http\\Transport\\Stream'),
			'curl'   => array('\\BabDev\\Http\\Transport\\Curl'),
			'socket' => array('\\BabDev\\Http\\Transport\\Socket')
		);
	}

	/**
	 * Tests the request method with a get request
	 *
	 * @param   array  $transportClass  The class to test
	 *
	 * @return  void
	 *
	 * @dataProvider  transportProvider
	 * @since         1.0
	 */
	public function testRequestGet($transportClass)
	{
		/* @type  $transport  \BabDev\Http\TransportInterface */
		$transport = new $transportClass($this->options);

		$response = $transport->request('get', new Uri($this->stubUrl), null, null, 60, 'BabDevTest/1.0');

		$body = json_decode($response->body);

		$this->assertEquals(
			$response->code,
			200
		);

		$this->assertEquals(
			$body->method,
			'GET'
		);
	}

	/**
	 * Tests the request method with a get request with a bad domain
	 *
	 * @param   string  $transportClass  The transport class to test
	 *
	 * @return  void
	 *
	 * @dataProvider       transportProvider
	 * @expectedException  \RuntimeException
	 * @since              1.0
	 */
	public function testBadDomainRequestGet($transportClass)
	{
		/* @type  $transport  \BabDev\Http\TransportInterface */
		$transport = new $transportClass($this->options);
		$response = $transport->request('get', new Uri('http://joomla.babdev.com'));
	}

	/**
	 * Tests the request method with a get request for non existant url
	 *
	 * @param   array  $transportClass  The class to test
	 *
	 * @return  void
	 *
	 * @dataProvider  transportProvider
	 * @since         1.0
	 */
	public function testRequestGet404($transportClass)
	{
		/* @type  $transport  \BabDev\Http\TransportInterface */
		$transport = new $transportClass($this->options);
		$response = $transport->request('get', new Uri($this->stubUrl . ':80'));
	}

	/**
	 * Tests the request method with a put request
	 *
	 * @param   array  $transportClass  The class to test
	 *
	 * @return  void
	 *
	 * @dataProvider  transportProvider
	 * @since         1.0
	 */
	public function testRequestPut($transportClass)
	{
		/* @type  $transport  \BabDev\Http\TransportInterface */
		$transport = new $transportClass($this->options);

		$response = $transport->request('put', new Uri($this->stubUrl));

		$body = json_decode($response->body);

		$this->assertEquals(
			$response->code,
			200
		);

		// Skip this assertion on HHVM, it's asserting $body->method is GET, see https://github.com/facebook/hhvm/issues/1876
		if (!defined('HHVM_VERSION'))
		{
			$this->assertEquals(
				$body->method,
				'PUT'
			);
		}
	}

	/**
	 * Tests the request method with a post request and array data
	 *
	 * @param   array  $transportClass  The class to test
	 *
	 * @return  void
	 *
	 * @dataProvider  transportProvider
	 * @since         1.0
	 */
	public function testRequestPost($transportClass)
	{
		/* @type  $transport  \BabDev\Http\TransportInterface */
		$transport = new $transportClass($this->options);

		$response = $transport->request('post', new Uri($this->stubUrl . '?test=okay'), array('key' => 'value'));

		$body = json_decode($response->body);

		$this->assertEquals(
			$response->code,
			200
		);

		$this->assertEquals(
			$body->method,
			'POST'
		);

		$this->assertEquals(
			$body->post->key,
			'value'
		);
	}

	/**
	 * Tests the request method with a post request and scalar data
	 *
	 * @param   array  $transportClass  The class to test
	 *
	 * @return  void
	 *
	 * @dataProvider  transportProvider
	 * @since         1.0
	 */
	public function testRequestPostScalar($transportClass)
	{
		/* @type  $transport  \BabDev\Http\TransportInterface */
		$transport = new $transportClass($this->options);

		$response = $transport->request('post', new Uri($this->stubUrl . '?test=okay'), 'key=value');

		$body = json_decode($response->body);

		$this->assertEquals(
			$response->code,
			200
		);

		$this->assertEquals(
			$body->method,
			'POST'
		);

		$this->assertEquals(
			$body->post->key,
			'value'
		);
	}
}

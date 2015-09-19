<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

/**
 * Abstract test case for TransifexObject instances
 */
abstract class TransifexTestCase extends \PHPUnit_Framework_TestCase
{
	/**
	 * Options for the Transifex object.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $options;

	/**
	 * Mock HTTP client object.
	 *
	 * @var    \PHPUnit_Framework_MockObject_MockObject
	 * @since  1.0
	 */
	protected $client;

	/**
	 * Mock Response object.
	 *
	 * @var    \PHPUnit_Framework_MockObject_MockObject
	 * @since  1.0
	 */
	protected $response;

	/**
	 * Sample JSON string.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * Sample JSON error message.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $errorString = '{"message": "Generic Error"}';

	/**
	 * {@inheritdoc}
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		$this->options  = array();
		$this->client   = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('\\Joomla\\Http\\Response');
	}

	/**
	 * Prepares the mock response for a failed API connection
	 *
	 * @param   string  $method  The method being called
	 * @param   string  $url     The URL being requested
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function prepareFailureTest($method, $url)
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method($method)
			->with($url)
			->willReturn($this->response);
	}

	/**
	 * Prepares the mock response for a successful API connection
	 *
	 * @param   string  $method  The method being called
	 * @param   string  $url     The URL being requested
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function prepareSuccessTest($method, $url, $code = 200)
	{
		$this->response->code = $code;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method($method)
			->with($url)
			->willReturn($this->response);
	}
}

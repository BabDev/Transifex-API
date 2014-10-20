<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Http;

use Joomla\Http\Response;

/**
 * Abstract test case for TransifexObject instances
 *
 * @since  1.0
 */
abstract class TransifexTestCase extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the Formats object.
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
		$this->options  = array();
		$this->client   = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('\\Joomla\\Http\\Response');
	}

	/**
	 * Prepares the test response for a failure (500) response
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
			->will($this->returnValue($this->response));
	}

	/**
	 * Prepares the test response for a success (200) response
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
			->will($this->returnValue($this->response));
	}
}

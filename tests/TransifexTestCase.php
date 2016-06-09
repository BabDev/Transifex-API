<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Http;
use Joomla\Http\Response;

/**
 * Abstract test case for TransifexObject instances.
 */
abstract class TransifexTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $response;

    /**
     * @var string
     */
    protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

    /**
     * @var string
     */
    protected $errorString = '{"message": "Generic Error"}';

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->options  = [];
        $this->client   = $this->createMock(Http::class);
        $this->response = $this->createMock(Response::class);
    }

    /**
     * Prepares the mock response for a failed API connection.
     *
     * @param string $method The method being called
     * @param string $url    The URL being requested
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
     * Prepares the mock response for a successful API connection.
     *
     * @param string $method The method being called
     * @param string $url    The URL being requested
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

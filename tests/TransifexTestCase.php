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

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

/**
 * Abstract test case for TransifexObject instances.
 */
abstract class TransifexTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $options = ['api.username' => 'test', 'api.password' => 'pass', 'base_uri' => 'https://www.transifex.com'];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $historyContainer = [];

    /**
     * @var string
     */
    protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

    /**
     * @var string
     */
    protected $errorString = '{"message": "Generic Error"}';

    /**
     * Create the Guzzle client for the test
     *
     * @param HandlerStack $stack
     */
    protected function createClient(HandlerStack $stack)
    {
        $history = Middleware::history($this->historyContainer);

        $stack->push($history);

        $this->client = new Client(['handler' => $stack]);
    }

    /**
     * Prepares the mock response for a failed API connection.
     */
    protected function prepareFailureTest()
    {
        $mock = new MockHandler([
            new Response(500, [], $this->errorString),
        ]);

        $this->createClient(HandlerStack::create($mock));
    }

    /**
     * Prepares the mock response for a successful API connection.
     *
     * @param int $code The expected HTTP code
     */
    protected function prepareSuccessTest(int $code = 200)
    {
        $mock = new MockHandler([
            new Response($code, [], $this->sampleString),
        ]);

        $this->createClient(HandlerStack::create($mock));
    }

    /**
     * Validate the request for a success test is valid
     *
     * @param string $path   The expected URI path
     * @param string $method The expected HTTP method
     * @param int    $code   The expected HTTP code
     */
    protected function validateSuccessTest(string $path, string $method = 'GET', int $code = 200)
    {
        // There should be one request in the stack now
        if (!isset($this->historyContainer[0])) {
            $this->fail('Request not completed.');
        }

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = $this->historyContainer[0]['response'];

        $this->assertSame(
            $method,
            $request->getMethod(),
            'The API did not use the right HTTP method.'
        );

        $this->assertSame(
            $path,
            $request->getUri()->getPath(),
            'The API did not request the right endpoint.'
        );

        $this->assertSame($code, $response->getStatusCode(), 'The API did not return the right HTTP code.');
    }
}

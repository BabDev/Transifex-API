<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Tests\Client\TransifexTestClient;
use GuzzleHttp\Psr7\Response;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use Http\Factory\Guzzle\UriFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Base test case for ApiConnector instances.
 */
abstract class ApiConnectorTestCase extends TestCase
{
    /**
     * @var array
     */
    protected $options = [
        'api.username' => 'test',
        'api.password' => 'pass',
        'base_uri'     => 'https://www.transifex.com',
    ];

    /**
     * @var TransifexTestClient
     */
    protected $client;

    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * @var UriFactoryInterface
     */
    protected $uriFactory;

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
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->client         = new TransifexTestClient();
        $this->requestFactory = new RequestFactory();
        $this->streamFactory  = new StreamFactory();
        $this->uriFactory     = new UriFactory();
    }

    /**
     * Asserts the request and response are in the intended state.
     *
     * @param string $path   The expected URI path
     * @param string $method The expected HTTP method
     * @param int    $code   The expected HTTP code
     */
    public function assertCorrectRequestAndResponse(string $path, string $method = 'GET', int $code = 200): void
    {
        static::assertCorrectRequestMethod($method, $this->client->getRequest()->getMethod());
        static::assertCorrectRequestPath($path, $this->client->getRequest()->getUri()->getPath());
        static::assertCorrectResponseCode($code, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Asserts that a request used the intended method
     *
     * @param string $expected The expected request method
     * @param string $actual   The actual request method
     * @param string $message  Error message for the test
     */
    public static function assertCorrectRequestMethod(
        string $expected,
        string $actual,
        string $message = 'The API did not use the right HTTP method.'
    ): void {
        static::assertSame($expected, $actual, $message);
    }

    /**
     * Asserts that a request connected to the correct path
     *
     * @param string $expected The expected request path
     * @param string $actual   The actual request path
     * @param string $message  Error message for the test
     */
    public static function assertCorrectRequestPath(
        string $expected,
        string $actual,
        string $message = 'The API did not request the right endpoint.'
    ): void {
        static::assertSame($expected, $actual, $message);
    }

    /**
     * Asserts that a response has the correct HTTP status code
     *
     * @param int    $expected The expected response code
     * @param int    $actual   The actual response code
     * @param string $message  Error message for the test
     */
    public static function assertCorrectResponseCode(
        int $expected,
        int $actual,
        string $message = 'The API did not return the right HTTP code.'
    ): void {
        static::assertSame($expected, $actual, $message);
    }

    /**
     * Prepares the mock response for a failed API connection.
     */
    protected function prepareFailureTest(): void
    {
        $this->client->setResponse(new Response(500, [], $this->errorString));
    }

    /**
     * Prepares the mock response for a successful API connection.
     *
     * @param int $code The expected HTTP code
     */
    protected function prepareSuccessTest(int $code = 200): void
    {
        $this->client->setResponse(new Response($code, [], $this->sampleString));
    }
}

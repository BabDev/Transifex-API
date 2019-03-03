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
    protected $options = ['api.username' => 'test', 'api.password' => 'pass', 'base_uri' => 'https://www.transifex.com'];

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

    /**
     * Validate the request for a failure test is valid.
     *
     * @param string $path   The expected URI path
     * @param string $method The expected HTTP method
     * @param int    $code   The expected HTTP code
     */
    protected function validateFailureTest(string $path, string $method = 'GET', int $code = 500): void
    {
        $this->assertSame(
            $method,
            $this->client->getRequest()->getMethod(),
            'The API did not use the right HTTP method.'
        );

        $this->assertSame(
            $path,
            $this->client->getRequest()->getUri()->getPath(),
            'The API did not request the right endpoint.'
        );

        $this->assertSame($code, $this->client->getResponse()->getStatusCode(), 'The API did not return the right HTTP code.');
    }

    /**
     * Validate the request for a success test is valid.
     *
     * @param string $path   The expected URI path
     * @param string $method The expected HTTP method
     * @param int    $code   The expected HTTP code
     */
    protected function validateSuccessTest(string $path, string $method = 'GET', int $code = 200): void
    {
        $this->assertSame(
            $method,
            $this->client->getRequest()->getMethod(),
            'The API did not use the right HTTP method.'
        );

        $this->assertSame(
            $path,
            $this->client->getRequest()->getUri()->getPath(),
            'The API did not request the right endpoint.'
        );

        $this->assertSame($code, $this->client->getResponse()->getStatusCode(), 'The API did not return the right HTTP code.');
    }
}

<?php declare(strict_types=1);

namespace BabDev\Transifex;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * Transifex API object class.
 */
abstract class TransifexObject
{
    /**
     * The HTTP client.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * The request factory.
     *
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * The stream factory.
     *
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * The URI factory.
     *
     * @var UriFactoryInterface
     */
    protected $uriFactory;

    /**
     * Options for the Transifex object.
     *
     * @var array
     */
    protected $options;

    /**
     * @param ClientInterface         $client         The HTTP client
     * @param RequestFactoryInterface $requestFactory The request factory
     * @param StreamFactoryInterface  $streamFactory  The stream factory
     * @param UriFactoryInterface     $uriFactory     The URI factory
     * @param array                   $options        Transifex options array
     */
    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        UriFactoryInterface $uriFactory,
        array $options = []
    ) {
        $this->client         = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory  = $streamFactory;
        $this->uriFactory     = $uriFactory;
        $this->options        = $options;
    }

    /**
     * Creates the Authorization header for the request
     *
     * @return string
     *
     * @throws \InvalidArgumentException if credentials are not set
     */
    protected function createAuthorizationHeader(): string
    {
        $username = $this->getOption('api.username');
        $password = $this->getOption('api.password');

        // The API requires HTTP Basic Authentication, we can't proceed without credentials
        if ($username === null || $password === null) {
            throw new \InvalidArgumentException('Missing credentials for API authentication.');
        }

        return 'Basic ' . \base64_encode("$username:$password");
    }

    /**
     * Create a Request object for the given URI
     *
     * This method will also set the Authorization header for the request
     *
     * @param string       $method
     * @param UriInterface $uri
     *
     * @return RequestInterface
     */
    protected function createRequest(string $method, UriInterface $uri): RequestInterface
    {
        $request = $this->requestFactory->createRequest($method, $uri);

        return $request->withHeader('Authorization', $this->createAuthorizationHeader());
    }

    /**
     * Create a Uri object for the path
     *
     * @param string $path
     *
     * @return UriInterface
     */
    protected function createUri(string $path): UriInterface
    {
        $baseUrl = $this->getOption('base_uri', 'https://www.transifex.com');

        return $this->uriFactory->createUri($baseUrl . $path);
    }

    /**
     * Get the authentication credentials for the API request.
     *
     * @return array
     *
     * @throws \InvalidArgumentException if credentials are not set
     */
    protected function getAuthData(): array
    {
        $username = $this->getOption('api.username');
        $password = $this->getOption('api.password');

        // The API requires HTTP Basic Authentication, we can't proceed without credentials
        if ($username === null || $password === null) {
            throw new \InvalidArgumentException('Missing credentials for API authentication.');
        }

        return [$username, $password];
    }

    /**
     * Get an option from the options store.
     *
     * @param string $key     The name of the option to get
     * @param mixed  $default The default value if the option is not set
     *
     * @return mixed The option value
     */
    protected function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Update an API endpoint with resource content.
     *
     * @param UriInterface $uri     URI object representing the API path to request
     * @param string       $content The content of the resource, this can either be a string of data or a file path
     * @param string       $type    The type of content in the $content variable, this should be either string or file
     *
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function updateResource(UriInterface $uri, string $content, string $type): ResponseInterface
    {
        // Verify the content type is allowed
        if (!\in_array($type, ['string', 'file'])) {
            throw new \InvalidArgumentException('The content type must be specified as file or string.');
        }

        $request = $this->createRequest('PUT', $uri);
        $request = $request->withHeader('Content-Type', 'application/json');

        if ($type == 'file') {
            if (!\file_exists($content)) {
                throw new \InvalidArgumentException(
                    \sprintf('The specified file, "%s", does not exist.', $content)
                );
            }

            $request = $request->withBody($this->streamFactory->createStreamFromFile($content));
        } else {
            $data = [
                'content' => $content,
            ];

            $request = $request->withBody($this->streamFactory->createStream(\json_encode($data)));
        }

        return $this->client->sendRequest($request);
    }
}

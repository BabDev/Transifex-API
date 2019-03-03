<?php declare(strict_types=1);

namespace BabDev\Transifex;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Factory class responsible for creating Transifex API objects.
 */
final class ApiFactory implements FactoryInterface
{
    /**
     * The HTTP client.
     *
     * @var ClientInterface
     */
    private $client;

    /**
     * The request factory.
     *
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * The stream factory.
     *
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * The URI factory.
     *
     * @var UriFactoryInterface
     */
    private $uriFactory;

    /**
     * @param ClientInterface         $client         The HTTP client
     * @param RequestFactoryInterface $requestFactory The request factory
     * @param StreamFactoryInterface  $streamFactory  The stream factory
     * @param UriFactoryInterface     $uriFactory     The URI factory
     */
    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        UriFactoryInterface $uriFactory
    ) {
        $this->client         = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory  = $streamFactory;
        $this->uriFactory     = $uriFactory;
    }

    /**
     * Factory method to create API connectors.
     *
     * @param string $name    Name of the API connector to retrieve
     * @param array  $options API connector options
     *
     * @return ApiConnector
     *
     * @throws Exception\UnknownApiConnectorException
     */
    public function createApiConnector(string $name, array $options = []): ApiConnector
    {
        $namespace = __NAMESPACE__ . '\\Connector';
        $class     = $namespace . '\\' . \ucfirst(\strtolower($name));

        if (\class_exists($class)) {
            return new $class($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $options);
        }

        // No class found, sorry!
        throw new Exception\UnknownApiConnectorException("Could not find an API object for '$name'.");
    }
}

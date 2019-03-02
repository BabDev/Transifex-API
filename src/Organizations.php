<?php declare(strict_types=1);

namespace BabDev\Transifex;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Transifex API Organizations class.
 *
 * @link https://docs.transifex.com/api/organizations
 */
class Organizations extends ApiConnector
{
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
        parent::__construct($client, $requestFactory, $streamFactory, $uriFactory, $options);

        // This API group uses the newer `api.transifex.com` subdomain, only change if the default www was given
        if (!$this->getOption('base_uri') || $this->getOption('base_uri') === 'https://www.transifex.com') {
            $this->setOption('base_uri', 'https://api.transifex.com');
        }
    }

    /**
     * Get the organizations the authenticated user belongs to.
     *
     * @return ResponseInterface
     */
    public function getOrganizations(): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri('/organizations/')));
    }
}

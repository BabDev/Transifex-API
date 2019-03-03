<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Organizations;
use BabDev\Transifex\Tests\ApiConnectorTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Organizations.
 */
class OrganizationsTest extends ApiConnectorTestCase
{
    /**
     * @testdox getOrganizations() returns a Response object indicating a successful API connection
     */
    public function testGetOrganizations(): void
    {
        $this->prepareSuccessTest();

        (new Organizations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getOrganizations();

        $this->validateSuccessTest('/organizations/');

        $this->assertSame(
            'api.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API request did not use the new api subdomain.'
        );
    }

    /**
     * @testdox getFormats() returns a Response object indicating a failed API connection
     */
    public function testGetOrganizationsFailure(): void
    {
        $this->prepareFailureTest();

        (new Organizations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getOrganizations();

        $this->validateFailureTest('/organizations/');

        $this->assertSame(
            'api.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API request did not use the new api subdomain.'
        );
    }
}

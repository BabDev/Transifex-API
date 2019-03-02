<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Organizations;

/**
 * Test class for \BabDev\Transifex\Organizations.
 */
class OrganizationsTest extends TransifexTestCase
{
    /**
     * @testdox getOrganizations() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\ApiConnector
     * @covers  \BabDev\Transifex\Organizations::__construct
     * @covers  \BabDev\Transifex\Organizations::getOrganizations
     *
     * @uses    \BabDev\Transifex\ApiConnector
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
     *
     * @covers  \BabDev\Transifex\Organizations::__construct
     * @covers  \BabDev\Transifex\Organizations::getOrganizations
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
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

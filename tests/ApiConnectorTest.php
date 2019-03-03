<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Connector\Formats;

/**
 * Test class for \BabDev\Transifex\ApiConnector.
 */
class ApiConnectorTest extends ApiConnectorTestCase
{
    /**
     * @testdox The API does not connect when API credentials are not available
     */
    public function testApiFailureWhenNoAuthenticationIsSet(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing credentials for API authentication.');

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, []))->getFormats();
    }

    /**
     * @testdox When a custom base URL is set in the options the API request goes to that URL
     */
    public function testCustomBaseUrlIsUsed(): void
    {
        $this->prepareSuccessTest();

        $this->options['base_uri'] = 'https://api.transifex.com';

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->validateSuccessTest('/api/2/formats');

        $this->assertSame(
            'api.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API did not use the right host.'
        );
    }
}

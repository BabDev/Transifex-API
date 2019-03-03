<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Formats;
use BabDev\Transifex\Tests\ApiConnectorTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Formats.
 */
final class FormatsTest extends ApiConnectorTestCase
{
    /**
     * @testdox getFormats() returns a Response object indicating a successful API connection
     */
    public function testGetFormats(): void
    {
        $this->prepareSuccessTest();

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->assertCorrectRequestAndResponse('/api/2/formats');
    }

    /**
     * @testdox getFormats() returns a Response object indicating a failed API connection
     */
    public function testGetFormatsFailure(): void
    {
        $this->prepareFailureTest();

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->assertCorrectRequestAndResponse('/api/2/formats', 'GET', 500);
    }
}

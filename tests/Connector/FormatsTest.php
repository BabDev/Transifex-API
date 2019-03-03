<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Formats;
use BabDev\Transifex\Tests\TransifexTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Formats.
 */
class FormatsTest extends TransifexTestCase
{
    /**
     * @testdox getFormats() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\ApiConnector
     * @covers  \BabDev\Transifex\Connector\Formats::getFormats
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetFormats(): void
    {
        $this->prepareSuccessTest();

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->validateSuccessTest('/api/2/formats');
    }

    /**
     * @testdox getFormats() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Connector\Formats::getFormats
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetFormatsFailure(): void
    {
        $this->prepareFailureTest();

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->validateFailureTest('/api/2/formats');
    }
}

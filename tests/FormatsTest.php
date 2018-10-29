<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Formats;

/**
 * Test class for \BabDev\Transifex\Formats.
 */
class FormatsTest extends TransifexTestCase
{
    /**
     * @testdox getFormats() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Formats::getFormats
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormats()
    {
        $this->prepareSuccessTest();

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->validateSuccessTest('/api/2/formats');
    }

    /**
     * @testdox getFormats() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Formats::getFormats
     * @covers  \BabDev\Transifex\TransifexObject
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormatsFailure()
    {
        $this->prepareFailureTest();

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->validateFailureTest('/api/2/formats');
    }
}

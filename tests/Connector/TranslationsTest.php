<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Translations;
use BabDev\Transifex\Tests\TransifexTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Translations.
 */
class TranslationsTest extends TransifexTestCase
{
    /**
     * @testdox getTranslation() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\ApiConnector
     * @covers  \BabDev\Transifex\Connector\Translations::getTranslation
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetTranslation(): void
    {
        $this->prepareSuccessTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getTranslation('babdev', 'babdev-transifex', 'en_US', 'default');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US');

        $this->assertSame(
            'mode=default&file',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getTranslation() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\ApiConnector
     * @covers  \BabDev\Transifex\Connector\Translations::getTranslation
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetTranslationFailure(): void
    {
        $this->prepareFailureTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getTranslation('babdev', 'babdev-transifex', 'en_US', 'default');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US');
    }

    /**
     * @testdox updateTranslation() with an attached file returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\ApiConnector
     * @covers  \BabDev\Transifex\Connector\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testUpdateTranslationFile(): void
    {
        $this->prepareSuccessTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslation(
            'babdev',
            'babdev-transifex',
            'en_US',
            __DIR__ . '/../stubs/source.ini',
            'file'
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() with inline content returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\ApiConnector
     * @covers  \BabDev\Transifex\Connector\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testUpdateTranslationString(): void
    {
        $this->prepareSuccessTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslation(
            'babdev',
            'babdev-transifex',
            'en_US',
            'TEST="Test"'
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\ApiConnector
     * @covers  \BabDev\Transifex\Connector\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testUpdateTranslationFailure(): void
    {
        $this->prepareFailureTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslation(
            'babdev',
            'babdev-transifex',
            'en_US',
            'TEST="Test"'
        );

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() throws an InvalidArgumentException when an invalid content type is specified
     *
     * @covers  \BabDev\Transifex\Connector\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\ApiConnector
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslationBadType(): void
    {
        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslation(
            'babdev',
            'babdev-transifex',
            'en_US',
            'TEST="Test"',
            'stuff'
        );
    }

    /**
     * @testdox updateTranslation() throws an InvalidArgumentException when a non-existing file is specified
     *
     * @covers  \BabDev\Transifex\Connector\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\ApiConnector
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslationUnexistingFile(): void
    {
        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslation(
            'babdev',
            'babdev-transifex',
            'en_US',
            __DIR__ . '/stubs/does-not-exist.ini',
            'file'
        );
    }
}

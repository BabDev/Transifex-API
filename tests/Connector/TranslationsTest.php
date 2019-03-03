<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Translations;
use BabDev\Transifex\Tests\ApiConnectorTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Translations.
 */
final class TranslationsTest extends ApiConnectorTestCase
{
    /**
     * @testdox getTranslation() returns a Response object indicating a successful API connection
     */
    public function testGetTranslation(): void
    {
        $this->prepareSuccessTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getTranslation('babdev', 'babdev-transifex', 'en_US', 'default');

        $this->assertCorrectRequestAndResponse('/api/2/project/babdev/resource/babdev-transifex/translation/en_US');

        $this->assertSame(
            'mode=default&file',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getTranslation() returns a Response object indicating a failed API connection
     */
    public function testGetTranslationFailure(): void
    {
        $this->prepareFailureTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getTranslation('babdev', 'babdev-transifex', 'en_US', 'default');

        $this->assertCorrectRequestAndResponse('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'GET', 500);
    }

    /**
     * @testdox updateTranslation() with an attached file returns a Response object indicating a successful API connection
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

        $this->assertCorrectRequestAndResponse('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() with inline content returns a Response object indicating a successful API connection
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

        $this->assertCorrectRequestAndResponse('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() returns a Response object indicating a failed API connection
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

        $this->assertCorrectRequestAndResponse('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT', 500);
    }

    /**
     * @testdox updateTranslation() throws an InvalidArgumentException when an invalid content type is specified
     */
    public function testUpdateTranslationBadType(): void
    {
        $this->expectException(\InvalidArgumentException::class);

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
     */
    public function testUpdateTranslationUnexistingFile(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslation(
            'babdev',
            'babdev-transifex',
            'en_US',
            __DIR__ . '/stubs/does-not-exist.ini',
            'file'
        );
    }
}

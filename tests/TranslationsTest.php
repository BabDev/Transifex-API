<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Translations;

/**
 * Test class for \BabDev\Transifex\Translations.
 */
class TranslationsTest extends TransifexTestCase
{
    /**
     * @testdox getTranslation() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translations::getTranslation
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetTranslation()
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
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translations::getTranslation
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetTranslationFailure()
    {
        $this->prepareFailureTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getTranslation('babdev', 'babdev-transifex', 'en_US', 'default');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US');
    }

    /**
     * @testdox updateTranslation() with an attached file returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslationFile()
    {
        $this->prepareSuccessTest();

        (new Translations($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslation(
            'babdev',
            'babdev-transifex',
            'en_US',
            __DIR__ . '/stubs/source.ini',
            'file'
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() with inline content returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslationString()
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
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslationFailure()
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
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslationBadType()
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
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslationUnexistingFile()
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

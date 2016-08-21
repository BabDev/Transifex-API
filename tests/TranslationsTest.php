<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Translations;

/**
 * Test class for \BabDev\Transifex\Translations.
 */
class TranslationsTest extends TransifexTestCase
{
    /**
     * @testdox getTranslation() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translations::getTranslation
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetTranslation()
    {
        $this->prepareSuccessTest();

        (new Translations($this->options, $this->client))->getTranslation('babdev', 'babdev-transifex', 'en_US', 'default');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'mode=default&file',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getTranslation() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translations::getTranslation
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetTranslationFailure()
    {
        $this->prepareFailureTest();

        (new Translations($this->options, $this->client))->getTranslation('babdev', 'babdev-transifex', 'en_US', 'default');
    }

    /**
     * @testdox updateTranslation() with an attached file returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslationFile()
    {
        $this->prepareSuccessTest();

        (new Translations($this->options, $this->client))->updateTranslation('babdev', 'babdev-transifex', 'en_US',
            __DIR__ . '/stubs/source.ini', 'file');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() with inline content returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslationString()
    {
        $this->prepareSuccessTest();

        (new Translations($this->options, $this->client))->updateTranslation('babdev', 'babdev-transifex', 'en_US',
            'TEST="Test"');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US', 'PUT');
    }

    /**
     * @testdox updateTranslation() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testUpdateTranslationFailure()
    {
        $this->prepareFailureTest();

        (new Translations($this->options, $this->client))->updateTranslation('babdev', 'babdev-transifex', 'en_US',
            'TEST="Test"');
    }

    /**
     * @testdox updateTranslation() throws an InvalidArgumentException when an invalid content type is specified
     *
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslationBadType()
    {
        (new Translations($this->options, $this->client))->updateTranslation('babdev', 'babdev-transifex', 'en_US',
            'TEST="Test"', 'stuff');
    }

    /**
     * @testdox updateTranslation() throws an InvalidArgumentException when a non-existing file is specified
     *
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslationUnexistingFile()
    {
        (new Translations($this->options, $this->client))->updateTranslation('babdev', 'babdev-transifex', 'en_US',
            __DIR__ . '/stubs/does-not-exist.ini', 'file');
    }
}

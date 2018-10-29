<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Translationstrings;

/**
 * Test class for \BabDev\Transifex\Translationstrings.
 */
class TranslationstringsTest extends TransifexTestCase
{
    /**
     * @testdox getPseudolocalizationStrings() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getPseudolocalizationStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetPseudolocalizationStrings()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getPseudolocalizationStrings('babdev', 'babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/pseudo/');

        $this->assertSame(
            'pseudo_type=MIXED',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getPseudolocalizationStrings() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getPseudolocalizationStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetPseudolocalizationStringsFailure()
    {
        $this->prepareFailureTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getPseudolocalizationStrings('babdev', 'babdev-transifex');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/pseudo/');
    }

    /**
     * @testdox getStrings() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStrings()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStrings('babdev', 'babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');
    }

    /**
     * @testdox getStrings() requesting full details returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetails()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStrings('babdev', 'babdev-transifex', 'en_US', true);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        $this->assertSame(
            'details',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting full details and the key returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetailsKey()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStrings(
            'babdev',
            'babdev-transifex',
            'en_US',
            true,
            ['key' => 'Yes']
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        $this->assertSame(
            'details&key=Yes',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting full details, key, and context returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetailsKeyContext()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStrings(
            'babdev',
            'babdev-transifex',
            'en_US',
            true,
            ['key' => 'Yes', 'context' => 'Something']
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        $this->assertSame(
            'details&key=Yes&context=Something',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting the key and context returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsKeyContext()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStrings(
            'babdev',
            'babdev-transifex',
            'en_US',
            false,
            ['key' => 'Yes', 'context' => 'Something']
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        $this->assertSame(
            'key=Yes&context=Something',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting a given context returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsContext()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStrings(
            'babdev',
            'babdev-transifex',
            'en_US',
            false,
            ['context' => 'Something']
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        $this->assertSame(
            'context=Something',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsFailure()
    {
        $this->prepareFailureTest();

        (new Translationstrings($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStrings('babdev', 'babdev-transifex', 'en_US');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');
    }
}

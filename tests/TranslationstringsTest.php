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

use BabDev\Transifex\Translationstrings;

/**
 * Test class for \BabDev\Transifex\Translationstrings.
 */
class TranslationstringsTest extends TransifexTestCase
{
    /**
     * @testdox getPseudolocalizationStrings() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getPseudolocalizationStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetPseudolocalizationStrings()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->options, $this->client))->getPseudolocalizationStrings('babdev', 'babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/pseudo/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'pseudo_type=MIXED',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getPseudolocalizationStrings() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getPseudolocalizationStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetPseudolocalizationStringsFailure()
    {
        $this->prepareFailureTest();

        (new Translationstrings($this->options, $this->client))->getPseudolocalizationStrings('babdev', 'babdev-transifex');
    }

    /**
     * @testdox getStrings() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStrings()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->options, $this->client))->getStrings('babdev', 'babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');
    }

    /**
     * @testdox getStrings() requesting full details returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetails()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->options, $this->client))->getStrings('babdev', 'babdev-transifex', 'en_US', true);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'details',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting full details and the key returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetailsKey()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->options, $this->client))->getStrings('babdev', 'babdev-transifex', 'en_US', true,
            ['key' => 'Yes']);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'details&key=Yes',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting full details, key, and context returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetailsKeyContext()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->options, $this->client))->getStrings('babdev', 'babdev-transifex', 'en_US', true,
            ['key' => 'Yes', 'context' => 'Something']);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'details&key=Yes&context=Something',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting the key and context returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsKeyContext()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->options, $this->client))->getStrings('babdev', 'babdev-transifex', 'en_US', false,
            ['key' => 'Yes', 'context' => 'Something']);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'key=Yes&context=Something',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() requesting a given context returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsContext()
    {
        $this->prepareSuccessTest();

        (new Translationstrings($this->options, $this->client))->getStrings('babdev', 'babdev-transifex', 'en_US', false,
            ['context' => 'Something']);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/translation/en_US/strings/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'context=Something',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getStrings() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetStringsFailure()
    {
        $this->prepareFailureTest();

        (new Translationstrings($this->options, $this->client))->getStrings('babdev', 'babdev-transifex', 'en_US');
    }
}

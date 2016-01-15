<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex\tests;

use BabDev\Transifex\Translationstrings;

/**
 * Test class for \BabDev\Transifex\Translationstrings.
 */
class TranslationstringsTest extends TransifexTestCase
{
    /**
     * @var Translationstrings
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Translationstrings($this->options, $this->client);
    }

    /**
     * @testdox getPseudolocalizationStrings() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getPseudolocalizationStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetPseudolocalizationStrings()
    {
        $this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/pseudo/?pseudo_type=MIXED');

        $this->assertSame(
            $this->object->getPseudolocalizationStrings('joomla', 'joomla-platform'),
            $this->response
        );
    }

    /**
     * @testdox getPseudolocalizationStrings() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getPseudolocalizationStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetPseudolocalizationStringsFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/pseudo/?pseudo_type=MIXED');

        $this->object->getPseudolocalizationStrings('joomla', 'joomla-platform');
    }

    /**
     * @testdox getStrings() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStrings()
    {
        $this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/translation/en_GB/strings/');

        $this->assertSame(
            $this->object->getStrings('joomla', 'joomla-platform', 'en_GB'),
            $this->response
        );
    }

    /**
     * @testdox getStrings() requesting full details returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetails()
    {
        $this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details');

        $this->assertSame(
            $this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true),
            $this->response
        );
    }

    /**
     * @testdox getStrings() requesting full details and the key returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetailsKey()
    {
        $this->prepareSuccessTest('get',
            '/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details\&key=Yes');

        $this->assertSame(
            $this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true, ['key' => 'Yes']),
            $this->response
        );
    }

    /**
     * @testdox getStrings() requesting full details, key, and context returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsDetailsKeyContext()
    {
        $this->prepareSuccessTest('get',
            '/project/joomla/resource/joomla-platform/translation/en_GB/strings/?details\&key=Yes\&context=Something');

        $this->assertSame(
            $this->object->getStrings('joomla', 'joomla-platform', 'en_GB', true,
                ['key' => 'Yes', 'context' => 'Something']),
            $this->response
        );
    }

    /**
     * @testdox getStrings() requesting the key and context returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsKeyContext()
    {
        $this->prepareSuccessTest('get',
            '/project/joomla/resource/joomla-platform/translation/en_GB/strings/?key=Yes\&context=Something');

        $this->assertSame(
            $this->object->getStrings('joomla', 'joomla-platform', 'en_GB', false,
                ['key' => 'Yes', 'context' => 'Something']),
            $this->response
        );
    }

    /**
     * @testdox getStrings() requesting a given context returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStringsContext()
    {
        $this->prepareSuccessTest('get',
            '/project/joomla/resource/joomla-platform/translation/en_GB/strings/?context=Something');

        $this->assertSame(
            $this->object->getStrings('joomla', 'joomla-platform', 'en_GB', false, ['context' => 'Something']),
            $this->response
        );
    }

    /**
     * @testdox getStrings() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translationstrings::getStrings
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetStringsFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/translation/en_GB/strings/');

        $this->object->getStrings('joomla', 'joomla-platform', 'en_GB');
    }
}

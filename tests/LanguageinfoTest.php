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

use BabDev\Transifex\Languageinfo;

/**
 * Test class for \BabDev\Transifex\Languageinfo.
 */
class LanguageinfoTest extends TransifexTestCase
{
    /**
     * @var Languageinfo
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Languageinfo($this->options, $this->client);
    }

    /**
     * @testdox getLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguage()
    {
        $this->prepareSuccessTest('get', '/language/en_GB/');

        $this->assertSame(
            $this->object->getLanguage('en_GB'),
            $this->response
        );
    }

    /**
     * @testdox getLanguage() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetLanguageFailure()
    {
        $this->prepareFailureTest('get', '/language/en_GB/');

        $this->object->getLanguage('en_GB');
    }

    /**
     * @testdox getLanguages() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguages()
    {
        $this->prepareSuccessTest('get', '/languages/');

        $this->assertSame(
            $this->object->getLanguages(),
            $this->response
        );
    }

    /**
     * @testdox getLanguages() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetLanguagesFailure()
    {
        $this->prepareFailureTest('get', '/languages/');

        $this->object->getLanguages();
    }
}

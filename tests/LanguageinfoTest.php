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
     * @testdox getLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguage()
    {
        $this->prepareSuccessTest();

        (new Languageinfo($this->options, $this->client))->getLanguage('en_GB');

        $this->validateSuccessTest('/api/2/language/en_GB/');
    }

    /**
     * @testdox getLanguage() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetLanguageFailure()
    {
        $this->prepareFailureTest();

        (new Languageinfo($this->options, $this->client))->getLanguage('en_GB');
    }

    /**
     * @testdox getLanguages() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguages()
    {
        $this->prepareSuccessTest();

        (new Languageinfo($this->options, $this->client))->getLanguages();

        $this->validateSuccessTest('/api/2/languages/');
    }

    /**
     * @testdox getLanguages() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetLanguagesFailure()
    {
        $this->prepareFailureTest();

        (new Languageinfo($this->options, $this->client))->getLanguages();
    }
}

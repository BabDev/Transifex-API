<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Languageinfo;

/**
 * Test class for \BabDev\Transifex\Languageinfo.
 */
class LanguageinfoTest extends TransifexTestCase
{
    /**
     * @testdox getLanguage() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguage
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetLanguage()
    {
        $this->prepareSuccessTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguage('en_GB');

        $this->validateSuccessTest('/api/2/language/en_GB/');
    }

    /**
     * @testdox getLanguage() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguage
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetLanguageFailure()
    {
        $this->prepareFailureTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguage('en_GB');

        $this->validateFailureTest('/api/2/language/en_GB/');
    }

    /**
     * @testdox getLanguages() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguages
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetLanguages()
    {
        $this->prepareSuccessTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguages();

        $this->validateSuccessTest('/api/2/languages/');
    }

    /**
     * @testdox getLanguages() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Languageinfo::getLanguages
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetLanguagesFailure()
    {
        $this->prepareFailureTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguages();

        $this->validateFailureTest('/api/2/languages/');
    }
}

<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Languageinfo;
use BabDev\Transifex\Tests\ApiConnectorTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Languageinfo.
 */
final class LanguageinfoTest extends ApiConnectorTestCase
{
    /**
     * @testdox getLanguage() returns a Response object indicating a successful API connection
     */
    public function testGetLanguage(): void
    {
        $this->prepareSuccessTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguage('en_GB');

        $this->assertCorrectRequestAndResponse('/api/2/language/en_GB/');
    }

    /**
     * @testdox getLanguage() returns a Response object indicating a failed API connection
     */
    public function testGetLanguageFailure(): void
    {
        $this->prepareFailureTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguage('en_GB');

        $this->assertCorrectRequestAndResponse('/api/2/language/en_GB/', 'GET', 500);
    }

    /**
     * @testdox getLanguages() returns a Response object indicating a successful API connection
     */
    public function testGetLanguages(): void
    {
        $this->prepareSuccessTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguages();

        $this->assertCorrectRequestAndResponse('/api/2/languages/');
    }

    /**
     * @testdox getLanguages() returns a Response object indicating a failed API connection
     */
    public function testGetLanguagesFailure(): void
    {
        $this->prepareFailureTest();

        (new Languageinfo($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguages();

        $this->assertCorrectRequestAndResponse('/api/2/languages/', 'GET', 500);
    }
}

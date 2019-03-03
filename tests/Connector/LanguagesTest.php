<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Languages;
use BabDev\Transifex\Tests\ApiConnectorTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Languages.
 */
class LanguagesTest extends ApiConnectorTestCase
{
    /**
     * @testdox createLanguage() returns a Response object indicating a successful API connection
     */
    public function testCreateLanguage(): void
    {
        $this->prepareSuccessTest(201);

        // Additional options
        $options = [
            'translators' => ['mbabker'],
            'reviewers'   => ['mbabker'],
            'list'        => 'test@example.com',
        ];

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createLanguage(
            'babdev-transifex',
            'en_US',
            ['mbabker'],
            $options,
            true
        );

        $this->validateSuccessTest('/api/2/project/babdev-transifex/languages/', 'POST', 201);

        $this->assertSame(
            'skip_invalid_username',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox createLanguage() returns a Response object indicating a failed API connection
     */
    public function testCreateLanguageFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createLanguage('babdev-transifex', 'en_US', ['mbabker']);

        $this->validateFailureTest('/api/2/project/babdev-transifex/languages/', 'POST');
    }

    /**
     * @testdox createLanguage() throws an InvalidArgumentException when no contributors are given
     */
    public function testCreateLanguageNoUsers(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createLanguage('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox deleteLanguage() returns a Response object indicating a successful API connection
     */
    public function testDeleteLanguage(): void
    {
        $this->prepareSuccessTest(204);

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteLanguage('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/', 'DELETE', 204);
    }

    /**
     * @testdox deleteLanguage() returns a Response object indicating a failed API connection
     */
    public function testDeleteLanguageFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteLanguage('babdev-transifex', 'en_US');

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/', 'DELETE');
    }

    /**
     * @testdox getCoordinators() returns a Response object indicating a successful API connection
     */
    public function testGetCoordinators(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getCoordinators('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/coordinators/');
    }

    /**
     * @testdox getCoordinators() returns a Response object indicating a failed API connection
     */
    public function testGetCoordinatorsFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getCoordinators('babdev-transifex', 'en_US');

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/coordinators/');
    }

    /**
     * @testdox getLanguage() returns a Response object indicating a successful API connection
     */
    public function testGetLanguage(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguage('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/');
    }

    /**
     * @testdox getLanguage() returns a Response object indicating a successful API connection
     */
    public function testGetLanguageWithDetails(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguage('babdev-transifex', 'en_US', true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/');

        $this->assertSame(
            'details',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getLanguage() returns a Response object indicating a failed API connection
     */
    public function testGetLanguageFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguage('babdev-transifex', 'en_US');

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/');
    }

    /**
     * @testdox getLanguages() returns a Response object indicating a successful API connection
     */
    public function testGetLanguages(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguages('babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/languages/');
    }

    /**
     * @testdox getLanguages() returns a Response object indicating a failed API connection
     */
    public function testGetLanguagesFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getLanguages('babdev-transifex');

        $this->validateFailureTest('/api/2/project/babdev-transifex/languages/');
    }

    /**
     * @testdox getReviewers() returns a Response object indicating a successful API connection
     */
    public function testGetReviewers(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getReviewers('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/reviewers/');
    }

    /**
     * @testdox getReviewers() returns a Response object indicating a failed API connection
     */
    public function testGetReviewersFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getReviewers('babdev-transifex', 'en_US');

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/reviewers/');
    }

    /**
     * @testdox getTranslators() returns a Response object indicating a successful API connection
     */
    public function testGetTranslators(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getTranslators('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/translators/');
    }

    /**
     * @testdox getTranslators() returns a Response object indicating a failed API connection
     */
    public function testGetTranslatorsFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getTranslators('babdev-transifex', 'en_US');

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/translators/');
    }

    /**
     * @testdox updateCoordinators() returns a Response object indicating a successful API connection
     */
    public function testUpdateCoordinators(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateCoordinators('babdev-transifex', 'en_US', ['mbabker'], true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/coordinators/', 'PUT');

        $this->assertSame(
            'skip_invalid_username',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox updateCoordinators() returns a Response object indicating a failed API connection
     */
    public function testUpdateCoordinatorsFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateCoordinators('babdev-transifex', 'en_US', ['mbabker']);

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/coordinators/', 'PUT');
    }

    /**
     * @testdox updateCoordinators() throws an InvalidArgumentException when no contributors are given
     */
    public function testUpdateCoordinatorsNoUsers(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateCoordinators('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox updateLanguage() returns a Response object indicating a successful API connection
     */
    public function testUpdateLanguage(): void
    {
        $this->prepareSuccessTest();

        // Additional options
        $options = [
            'translators' => ['mbabker'],
            'reviewers'   => ['mbabker'],
            'list'        => 'test@example.com',
        ];

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateLanguage('babdev-transifex', 'en_US', ['mbabker'], $options);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/', 'PUT');
    }

    /**
     * @testdox updateLanguage() returns a Response object indicating a failed API connection
     */
    public function testUpdateLanguageFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateLanguage('babdev-transifex', 'en_US', ['mbabker']);

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/', 'PUT');
    }

    /**
     * @testdox updateLanguage() throws an InvalidArgumentException when no contributors are given
     */
    public function testUpdateLanguageNoUsers(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateLanguage('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox updateReviewers() returns a Response object indicating a successful API connection
     */
    public function testUpdateReviewers(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateReviewers('babdev-transifex', 'en_US', ['mbabker'], true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/reviewers/', 'PUT');

        $this->assertSame(
            'skip_invalid_username',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox updateReviewers() returns a Response object indicating a failed API connection
     */
    public function testUpdateReviewersFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateReviewers('babdev-transifex', 'en_US', ['mbabker']);

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/reviewers/', 'PUT');
    }

    /**
     * @testdox updateReviewers() throws an InvalidArgumentException when no contributors are given
     */
    public function testUpdateReviewersNoUsers(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateReviewers('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox updateTranslators() returns a Response object indicating a successful API connection
     */
    public function testUpdateTranslators(): void
    {
        $this->prepareSuccessTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslators('babdev-transifex', 'en_US', ['mbabker'], true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/translators/', 'PUT');

        $this->assertSame(
            'skip_invalid_username',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox updateTranslators() returns a Response object indicating a failed API connection
     */
    public function testUpdateTranslatorsFailure(): void
    {
        $this->prepareFailureTest();

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslators('babdev-transifex', 'en_US', ['mbabker']);

        $this->validateFailureTest('/api/2/project/babdev-transifex/language/en_US/translators/', 'PUT');
    }

    /**
     * @testdox updateTranslators() throws an InvalidArgumentException when no contributors are given
     */
    public function testUpdateTranslatorsNoUsers(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Languages($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateTranslators('babdev-transifex', 'en_US', []);
    }
}

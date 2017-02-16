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

use BabDev\Transifex\Languages;

/**
 * Test class for \BabDev\Transifex\Languages.
 */
class LanguagesTest extends TransifexTestCase
{
    /**
     * @testdox createLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::createLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCreateLanguage()
    {
        $this->prepareSuccessTest(201);

        // Additional options
        $options = [
            'translators' => ['mbabker'],
            'reviewers'   => ['mbabker'],
            'list'        => 'test@example.com',
        ];

        (new Languages($this->options, $this->client))->createLanguage('babdev-transifex', 'en_US', ['mbabker'],
            $options, true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/languages/', 'POST', 201);

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'skip_invalid_username',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox createLanguage() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::createLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testCreateLanguageFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->createLanguage('babdev-transifex', 'en_US', ['mbabker']);
    }

    /**
     * @testdox createLanguage() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::createLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateLanguageNoUsers()
    {
        (new Languages($this->options, $this->client))->createLanguage('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox deleteLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::deleteLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testDeleteLanguage()
    {
        $this->prepareSuccessTest(204);

        (new Languages($this->options, $this->client))->deleteLanguage('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/', 'DELETE', 204);
    }

    /**
     * @testdox deleteLanguage() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::deleteLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testDeleteLanguageFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->deleteLanguage('babdev-transifex', 'en_US');
    }

    /**
     * @testdox getCoordinators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getCoordinators
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetCoordinators()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->getCoordinators('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/coordinators/');
    }

    /**
     * @testdox getCoordinators() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getCoordinators
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetCoordinatorsFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->getCoordinators('babdev-transifex', 'en_US');
    }

    /**
     * @testdox getLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguage()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->getLanguage('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/');
    }

    /**
     * @testdox getLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguageWithDetails()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->getLanguage('babdev-transifex', 'en_US', true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'details',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getLanguage() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetLanguageFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->getLanguage('babdev-transifex', 'en_US');
    }

    /**
     * @testdox getLanguages() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguages()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->getLanguages('babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/languages/');
    }

    /**
     * @testdox getLanguages() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetLanguagesFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->getLanguages('babdev-transifex');
    }

    /**
     * @testdox getReviewers() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getReviewers
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetReviewers()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->getReviewers('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/reviewers/');
    }

    /**
     * @testdox getReviewers() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getReviewers
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetReviewersFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->getReviewers('babdev-transifex', 'en_US');
    }

    /**
     * @testdox getTranslators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getTranslators
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetTranslators()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->getTranslators('babdev-transifex', 'en_US');

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/translators/');
    }

    /**
     * @testdox getTranslators() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getTranslators
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetTranslatorsFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->getTranslators('babdev-transifex', 'en_US');
    }

    /**
     * @testdox updateCoordinators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateCoordinators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateCoordinators()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->updateCoordinators('babdev-transifex', 'en_US', ['mbabker'], true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/coordinators/', 'PUT');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'skip_invalid_username',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox updateCoordinators() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateCoordinators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testUpdateCoordinatorsFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->updateCoordinators('babdev-transifex', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateCoordinators() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateCoordinators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateCoordinatorsNoUsers()
    {
        (new Languages($this->options, $this->client))->updateCoordinators('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox updateLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateLanguage()
    {
        $this->prepareSuccessTest();

        // Additional options
        $options = [
            'translators' => ['mbabker'],
            'reviewers'   => ['mbabker'],
            'list'        => 'test@example.com',
        ];

        (new Languages($this->options, $this->client))->updateLanguage('babdev-transifex', 'en_US', ['mbabker'], $options);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/', 'PUT');
    }

    /**
     * @testdox updateLanguage() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testUpdateLanguageFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->updateLanguage('babdev-transifex', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateLanguage() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateLanguage
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateLanguageNoUsers()
    {
        (new Languages($this->options, $this->client))->updateLanguage('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox updateReviewers() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateReviewers
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateReviewers()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->updateReviewers('babdev-transifex', 'en_US', ['mbabker'], true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/reviewers/', 'PUT');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'skip_invalid_username',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox updateReviewers() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateReviewers
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testUpdateReviewersFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->updateReviewers('babdev-transifex', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateReviewers() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateReviewers
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateReviewersNoUsers()
    {
        (new Languages($this->options, $this->client))->updateReviewers('babdev-transifex', 'en_US', []);
    }

    /**
     * @testdox updateTranslators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateTranslators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslators()
    {
        $this->prepareSuccessTest();

        (new Languages($this->options, $this->client))->updateTranslators('babdev-transifex', 'en_US', ['mbabker'], true);

        $this->validateSuccessTest('/api/2/project/babdev-transifex/language/en_US/translators/', 'PUT');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'skip_invalid_username',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox updateTranslators() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateTranslators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testUpdateTranslatorsFailure()
    {
        $this->prepareFailureTest();

        (new Languages($this->options, $this->client))->updateTranslators('babdev-transifex', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateTranslators() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateTranslators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslatorsNoUsers()
    {
        (new Languages($this->options, $this->client))->updateTranslators('babdev-transifex', 'en_US', []);
    }
}

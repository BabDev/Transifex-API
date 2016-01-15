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
     * @var Languages
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Languages($this->options, $this->client);
    }

    /**
     * @testdox createLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::createLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCreateLanguage()
    {
        $this->prepareSuccessTest('post', '/project/joomla-platform/languages/?skip_invalid_username', 201);

        // Additional options
        $options = [
            'translators' => ['mbabker'],
            'reviewers'   => ['mbabker'],
            'list'        => 'test@example.com',
        ];

        $this->assertSame(
            $this->object->createLanguage('joomla-platform', 'en_GB', ['mbabker'], $options, true),
            $this->response
        );
    }

    /**
     * @testdox createLanguage() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::createLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testCreateLanguageFailure()
    {
        $this->prepareFailureTest('post', '/project/joomla-platform/languages/');

        $this->object->createLanguage('joomla-platform', 'en_GB', ['mbabker']);
    }

    /**
     * @testdox createLanguage() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::createLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateLanguageNoUsers()
    {
        $this->object->createLanguage('joomla-platform', 'en_US', []);
    }

    /**
     * @testdox deleteLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::deleteLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testDeleteLanguage()
    {
        $this->prepareSuccessTest('delete', '/project/joomla-platform/language/en_US/', 204);

        $this->assertSame(
            $this->object->deleteLanguage('joomla-platform', 'en_US'),
            $this->response
        );
    }

    /**
     * @testdox deleteLanguage() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::deleteLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testDeleteLanguageFailure()
    {
        $this->prepareFailureTest('delete', '/project/joomla-platform/language/en_US/');

        $this->object->deleteLanguage('joomla-platform', 'en_US');
    }

    /**
     * @testdox getCoordinators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getCoordinators
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetCoordinators()
    {
        $this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/coordinators/');

        $this->assertSame(
            $this->object->getCoordinators('joomla-platform', 'en_US'),
            $this->response
        );
    }

    /**
     * @testdox getCoordinators() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getCoordinators
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetCoordinatorsFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/coordinators/');

        $this->object->getCoordinators('joomla-platform', 'en_US');
    }

    /**
     * @testdox getLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguage()
    {
        $this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/');

        $this->assertSame(
            $this->object->getLanguage('joomla-platform', 'en_US'),
            $this->response
        );
    }

    /**
     * @testdox getLanguage() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetLanguageFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/');

        $this->object->getLanguage('joomla-platform', 'en_US');
    }

    /**
     * @testdox getLanguages() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetLanguages()
    {
        $this->prepareSuccessTest('get', '/project/joomla-platform/languages/');

        $this->assertSame(
            $this->object->getLanguages('joomla-platform'),
            $this->response
        );
    }

    /**
     * @testdox getLanguages() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getLanguages
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetLanguagesFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla-platform/languages/');

        $this->object->getLanguages('joomla-platform');
    }

    /**
     * @testdox getReviewers() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getReviewers
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetReviewers()
    {
        $this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/reviewers/');

        $this->assertSame(
            $this->object->getReviewers('joomla-platform', 'en_US'),
            $this->response
        );
    }

    /**
     * @testdox getReviewers() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getReviewers
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetReviewersFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/reviewers/');

        $this->object->getReviewers('joomla-platform', 'en_US');
    }

    /**
     * @testdox getTranslators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::getTranslators
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetTranslators()
    {
        $this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/translators/');

        $this->assertSame(
            $this->object->getTranslators('joomla-platform', 'en_US'),
            $this->response
        );
    }

    /**
     * @testdox getTranslators() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::getTranslators
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetTranslatorsFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/translators/');

        $this->object->getTranslators('joomla-platform', 'en_US');
    }

    /**
     * @testdox updateCoordinators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateCoordinators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateCoordinators()
    {
        $this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/coordinators/?skip_invalid_username');

        $this->assertSame(
            $this->object->updateCoordinators('joomla-platform', 'en_US', ['mbabker'], true),
            $this->response
        );
    }

    /**
     * @testdox updateCoordinators() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateCoordinators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testUpdateCoordinatorsFailure()
    {
        $this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/coordinators/');

        $this->object->updateCoordinators('joomla-platform', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateCoordinators() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateCoordinators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateCoordinatorsNoUsers()
    {
        $this->object->updateCoordinators('joomla-platform', 'en_US', []);
    }

    /**
     * @testdox updateLanguage() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateLanguage()
    {
        $this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/');

        // Additional options
        $options = [
            'translators' => ['mbabker'],
            'reviewers'   => ['mbabker'],
            'list'        => 'test@example.com',
        ];

        $this->assertSame(
            $this->object->updateLanguage('joomla-platform', 'en_US', ['mbabker'], $options),
            $this->response
        );
    }

    /**
     * @testdox updateLanguage() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testUpdateLanguageFailure()
    {
        $this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/');

        $this->object->updateLanguage('joomla-platform', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateLanguage() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateLanguage
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateLanguageNoUsers()
    {
        $this->object->updateLanguage('joomla-platform', 'en_US', []);
    }

    /**
     * @testdox updateReviewers() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateReviewers
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateReviewers()
    {
        $this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/reviewers/?skip_invalid_username');

        $this->assertSame(
            $this->object->updateReviewers('joomla-platform', 'en_US', ['mbabker'], true),
            $this->response
        );
    }

    /**
     * @testdox updateReviewers() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateReviewers
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testUpdateReviewersFailure()
    {
        $this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/reviewers/');

        $this->object->updateReviewers('joomla-platform', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateReviewers() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateReviewers
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateReviewersNoUsers()
    {
        $this->object->updateReviewers('joomla-platform', 'en_US', []);
    }

    /**
     * @testdox updateTranslators() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateTranslators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslators()
    {
        $this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/translators/?skip_invalid_username');

        $this->assertSame(
            $this->object->updateTranslators('joomla-platform', 'en_US', ['mbabker'], true),
            $this->response
        );
    }

    /**
     * @testdox updateTranslators() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Languages::updateTranslators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testUpdateTranslatorsFailure()
    {
        $this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/translators/');

        $this->object->updateTranslators('joomla-platform', 'en_US', ['mbabker']);
    }

    /**
     * @testdox updateTranslators() throws an InvalidArgumentException when no contributors are given
     *
     * @covers  \BabDev\Transifex\Languages::updateTranslators
     * @covers  \BabDev\Transifex\Languages::updateTeam
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslatorsNoUsers()
    {
        $this->object->updateTranslators('joomla-platform', 'en_US', []);
    }
}

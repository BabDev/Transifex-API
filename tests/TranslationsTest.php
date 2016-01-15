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

use BabDev\Transifex\Translations;

/**
 * Test class for \BabDev\Transifex\Translations.
 */
class TranslationsTest extends TransifexTestCase
{
    /**
     * @var Translations
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Translations($this->options, $this->client);
    }

    /**
     * @testdox getTranslation() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translations::getTranslation
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetTranslation()
    {
        $this->prepareSuccessTest(
            'get',
            '/project/joomla/resource/joomla-platform/translation/en_GB?mode=default&file'
        );

        $this->assertSame(
            $this->object->getTranslation('joomla', 'joomla-platform', 'en_GB', 'default'),
            $this->response
        );
    }

    /**
     * @testdox getTranslation() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Translations::getTranslation
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetTranslationFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/translation/en_GB');

        $this->object->getTranslation('joomla', 'joomla-platform', 'en_GB');
    }

    /**
     * @testdox updateTranslation() with an attached file returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslationFile()
    {
        $this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

        $this->assertSame(
            $this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', __DIR__ . '/stubs/source.ini',
                'file'),
            $this->response
        );
    }

    /**
     * @testdox updateTranslation() with inline content returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateTranslationString()
    {
        $this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

        $this->assertSame(
            $this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"'),
            $this->response
        );
    }

    /**
     * @testdox updateTranslation() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testUpdateTranslationFailure()
    {
        $this->prepareFailureTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

        $this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"');
    }

    /**
     * @testdox updateTranslation() throws an InvalidArgumentException when an invalid content type is specified
     *
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @covers  \BabDev\Transifex\Translations::updateTranslation
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateTranslationBadType()
    {
        $this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"', 'stuff');
    }
}

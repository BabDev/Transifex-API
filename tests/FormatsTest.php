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

use BabDev\Transifex\Formats;

/**
 * Test class for \BabDev\Transifex\Formats.
 */
class FormatsTest extends TransifexTestCase
{
    /**
     * @var Formats
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Formats($this->options, $this->client);
    }

    /**
     * @testdox getFormats() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\Formats::getFormats
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormats()
    {
        $this->prepareSuccessTest('get', '/formats');

        $this->assertSame(
            $this->object->getFormats(),
            $this->response
        );
    }

    /**
     * @testdox getFormats() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Formats::getFormats
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetFormatsFailure()
    {
        $this->prepareFailureTest('get', '/formats');

        $this->object->getFormats();
    }
}

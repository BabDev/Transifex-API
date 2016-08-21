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

use BabDev\Transifex\Formats;

/**
 * Test class for \BabDev\Transifex\Formats.
 */
class FormatsTest extends TransifexTestCase
{
    /**
     * @testdox getFormats() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\Formats::getFormats
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormats()
    {
        $this->prepareSuccessTest();

        (new Formats($this->options, $this->client))->getFormats();

        $this->validateSuccessTest('/api/2/formats');
    }

    /**
     * @testdox getFormats() throws a ServerException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Formats::getFormats
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetFormatsFailure()
    {
        $this->prepareFailureTest();

        (new Formats($this->options, $this->client))->getFormats();
    }
}

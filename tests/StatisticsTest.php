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

use BabDev\Transifex\Statistics;

/**
 * Test class for \BabDev\Transifex\Statistics.
 */
class StatisticsTest extends TransifexTestCase
{
    /**
     * @var Statistics
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Statistics($this->options, $this->client);
    }

    /**
     * @testdox getStatistics() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Statistics::getStatistics
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetStatistics()
    {
        $this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/stats/');

        $this->assertSame(
            $this->object->getStatistics('joomla', 'joomla-platform'),
            $this->response
        );
    }

    /**
     * @testdox getStatistics() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Statistics::getStatistics
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetStatisticsFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/stats/');

        $this->object->getStatistics('joomla', 'joomla-platform');
    }
}

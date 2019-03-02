<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Statistics;

/**
 * Test class for \BabDev\Transifex\Statistics.
 */
class StatisticsTest extends TransifexTestCase
{
    /**
     * @testdox getStatistics() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Statistics::getStatistics
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetStatistics()
    {
        $this->prepareSuccessTest();

        (new Statistics($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStatistics('babdev', 'babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/stats/');
    }

    /**
     * @testdox getStatistics() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Statistics::getStatistics
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetStatisticsFailure()
    {
        $this->prepareFailureTest();

        (new Statistics($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStatistics('babdev', 'babdev-transifex');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/stats/');
    }
}

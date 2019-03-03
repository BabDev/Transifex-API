<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests\Connector;

use BabDev\Transifex\Connector\Statistics;
use BabDev\Transifex\Tests\ApiConnectorTestCase;

/**
 * Test class for \BabDev\Transifex\Connector\Statistics.
 */
final class StatisticsTest extends ApiConnectorTestCase
{
    /**
     * @testdox getStatistics() returns a Response object indicating a successful API connection
     */
    public function testGetStatistics(): void
    {
        $this->prepareSuccessTest();

        (new Statistics($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStatistics('babdev', 'babdev-transifex');

        $this->assertCorrectRequestAndResponse('/api/2/project/babdev/resource/babdev-transifex/stats/');
    }

    /**
     * @testdox getStatistics() returns a Response object indicating a failed API connection
     */
    public function testGetStatisticsFailure(): void
    {
        $this->prepareFailureTest();

        (new Statistics($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getStatistics('babdev', 'babdev-transifex');

        $this->assertCorrectRequestAndResponse('/api/2/project/babdev/resource/babdev-transifex/stats/', 'GET', 500);
    }
}

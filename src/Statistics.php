<?php declare(strict_types=1);

namespace BabDev\Transifex;

use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API Statistics class.
 *
 * @link http://docs.transifex.com/api/statistics/
 */
class Statistics extends ApiConnector
{
    /**
     * Get statistics on a specified resource.
     *
     * @param string $project  The slug for the project to pull from
     * @param string $resource The slug for the resource to pull from
     * @param string $lang     An optional language code to return data only for a specified language
     *
     * @return ResponseInterface
     */
    public function getStatistics(string $project, string $resource, string $lang = ''): ResponseInterface
    {
        return $this->client->sendRequest($this->createRequest('GET', $this->createUri("/api/2/project/$project/resource/$resource/stats/$lang")));
    }
}

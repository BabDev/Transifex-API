<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex;

/**
 * Transifex API Statistics class.
 *
 * @link http://docs.transifex.com/developer/api/statistics
 */
class Statistics extends TransifexObject
{
    /**
     * Method to get statistics on a specified resource.
     *
     * @param string $project  The slug for the project to pull from.
     * @param string $resource The slug for the resource to pull from.
     * @param string $lang     An optional language code to return data only for a specified language.
     *
     * @return \Joomla\Http\Response
     */
    public function getStatistics($project, $resource, $lang = null)
    {
        // Build the request path.
        $path = '/project/' . $project . '/resource/' . $resource . '/stats/' . $lang;

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}

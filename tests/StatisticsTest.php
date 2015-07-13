<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Statistics;

/**
 * Test class for \BabDev\Transifex\Statistics.
 */
class StatisticsTest extends TransifexTestCase
{
	/**
	 * Object being tested.
	 *
	 * @var  Statistics
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
	 * @testdox  getStatistics() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Statistics::getStatistics
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
}

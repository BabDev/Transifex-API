<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Statistics;

/**
 * Test class for \BabDev\Transifex\Statistics.
 *
 * @since  1.0
 */
class StatisticsTest extends TransifexTestCase
{
	/**
	 * @var    Statistics  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Statistics($this->options, $this->client);
	}

	/**
	 * Tests the getStatistics method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Statistics::getStatistics
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStatistics()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/stats/');

		$this->assertEquals(
			$this->object->getStatistics('joomla', 'joomla-platform'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getStatistics method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Statistics::getStatistics
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetStatisticsFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/stats/');

		$this->object->getStatistics('joomla', 'joomla-platform');
	}
}

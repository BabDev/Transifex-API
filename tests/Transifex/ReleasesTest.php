<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Releases;

/**
 * Test class for \BabDev\Transifex\Releases.
 *
 * @since  1.0
 */
class ReleasesTest extends TransifexTestCase
{
	/**
	 * @var    Releases  Object under test.
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

		$this->object = new Releases($this->options, $this->client);
	}

	/**
	 * Tests the getRelease method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Releases::getRelease
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetRelease()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/release/12.1/');

		$this->assertEquals(
			$this->object->getRelease('joomla-platform', '12.1'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getRelease method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Releases::getRelease
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetReleaseFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla-platform/release/12.1/');

		$this->object->getRelease('joomla-platform', '12.1');
	}
}

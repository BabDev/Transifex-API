<?php
/**
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Formats;

/**
 * Test class for \BabDev\Transifex\Formats.
 *
 * @since  1.0
 */
class FormatsTest extends TransifexTestCase
{
	/**
	 * @var    Formats  Object under test.
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

		$this->object = new Formats($this->options, $this->client);
	}

	/**
	 * Tests the getFormats method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Formats::getFormats
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetFormats()
	{
		$this->prepareSuccessTest('get', '/formats');

		$this->assertEquals(
			$this->object->getFormats(),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getList method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Formats::getFormats
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetFormatsFailure()
	{
		$this->prepareFailureTest('get', '/formats');

		$this->object->getFormats();
	}
}

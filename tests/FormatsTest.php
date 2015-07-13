<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Formats;

/**
 * Test class for \BabDev\Transifex\Formats.
 */
class FormatsTest extends TransifexTestCase
{
	/**
	 * Object being tested.
	 *
	 * @var  Formats
	 */
	private $object;

	/**
	 * {@inheritdoc}
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Formats($this->options, $this->client);
	}

	/**
	 * @testdox  getFormats() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Formats::getFormats
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetFormats()
	{
		$this->prepareSuccessTest('get', '/formats');

		$this->assertSame(
			$this->object->getFormats(),
			$this->response
		);
	}
}

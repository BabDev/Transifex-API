<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Http;

use BabDev\Http\HttpFactory;

/**
 * Test class for \BabDev\Http\HttpFactory.
 *
 * @since  1.0
 */
class HttpFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Tests the getHttp method.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetHttp()
	{
		$this->assertInstanceOf(
			'\\BabDev\\Http\\Http',
			HttpFactory::getHttp()
		);
	}

	/**
	 * Tests the getAvailableDriver method.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetAvailableDriver()
	{
		$this->assertFalse(
			HttpFactory::getAvailableDriver(array(), array()),
			'Passing an empty array should return false due to there being no adapters to test'
		);

		$this->assertFalse(
			HttpFactory::getAvailableDriver(array(), array('fopen')),
			'A false should be returned if a class is not present or supported'
		);
	}
}

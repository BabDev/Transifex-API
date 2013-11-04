<?php
/**
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Tests\Http;

use BabDev\Http\HttpFactory;

use Joomla\Registry\Registry;

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
		$this->assertThat(
			HttpFactory::getHttp(),
			$this->isInstanceOf('\\BabDev\\Http\\Http')
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
		$this->assertThat(
			HttpFactory::getAvailableDriver(new Registry, array()),
			$this->isFalse(),
			'Passing an empty array should return false due to there being no adapters to test'
		);

		$this->assertThat(
			HttpFactory::getAvailableDriver(new Registry, array('fopen')),
			$this->isFalse(),
			'A false should be returned if a class is not present or supported'
		);
	}
}

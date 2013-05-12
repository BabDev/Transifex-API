<?php
/**
 * @package     BabDev.UnitTest
 * @subpackage  HTTP
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for BDHttpFactory.
 *
 * @package     BabDev.UnitTest
 * @subpackage  HTTP
 * @since       1.0
 */
class BDHttpFactoryTest extends PHPUnit_Framework_TestCase
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
			BDHttpFactory::getHttp(),
			$this->isInstanceOf('BDHttp')
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
			BDHttpFactory::getAvailableDriver(new JRegistry, array()),
			$this->isFalse(),
			'Passing an empty array should return false due to there being no adapters to test'
		);

		$this->assertThat(
			BDHttpFactory::getAvailableDriver(new JRegistry, array('fopen')),
			$this->isFalse(),
			'A false should be returned if a class is not present or supported'
		);
	}
}

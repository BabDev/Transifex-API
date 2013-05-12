<?php
/**
 * BabDev Version Package

 * @package     BabDev.Library
 * @subpackage  Version
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Version information class for the BabDev Libraries.
 *
 * @package     BabDev.Library
 * @subpackage  Version
 * @since       1.0
 */
final class BDVersion
{
	// Product name.
	const PRODUCT = 'BabDev Library';

	// Major version.
	const MAJOR = '1';

	// Minor version.
	const MINOR = '0';

	// Maintenance version.
	const MAINTENANCE = '0.alpha';

	// Development STATUS.
	const STATUS = 'Alpha';

	// Release date.
	const RELEASE_DATE = '05-May-2012';

	// Release time.
	const RELEASE_TIME = '00:00';

	// Release timezone.
	const RELEASE_TIME_ZONE = 'GMT';

	// Copyright Notice.
	const COPYRIGHT = 'Copyright (C) 2012-2013 Michael Babker. All rights reserved.';

	/**
	 * Compares a PHP standard version number against the current library version.
	 *
	 * @param   string  $minimum  The minimum version of the library which is compatible.
	 *
	 * @return  boolean  True if the version is compatible.
	 *
	 * @see     http://www.php.net/version_compare
	 * @since   1.0
	 */
	public static function isCompatible($minimum)
	{
		return (version_compare(self::getShortVersion(), $minimum, 'eq') == 1);
	}

	/**
	 * Gets a PHP standard version string for the current library.
	 *
	 * @return  string  Version string.
	 *
	 * @since   1.0
	 * @codeCoverageIgnore
	 */
	public static function getShortVersion()
	{
		return self::MAJOR . '.' . self::MINOR . '.' . self::MAINTENANCE;
	}

	/**
	 * Gets a version string for the current library with all release information.
	 *
	 * @return  string  Complete version string.
	 *
	 * @since   1.0
	 * @codeCoverageIgnore
	 */
	public static function getLongVersion()
	{
		return self::PRODUCT . ' ' . self::MAJOR . '.' . self::MINOR . '.' . self::MAINTENANCE . ' ' . self::STATUS . ' '
			. self::RELEASE_DATE . ' ' . self::RELEASE_TIME . ' ' . self::RELEASE_TIME_ZONE;
	}
}

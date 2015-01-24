<?php
/**
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Translations;

/**
 * Test class for \BabDev\Transifex\Translations.
 *
 * @since  1.0
 */
class TranslationsTest extends TransifexTestCase
{
	/**
	 * @var    Translations  Object under test.
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

		$this->object = new Translations($this->options, $this->client);
	}

	/**
	 * Tests the getTranslation method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translations::getTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslation()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/translation/en_GB?mode=default&file');

		$this->assertEquals(
			$this->object->getTranslation('joomla', 'joomla-platform', 'en_GB', 'default'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getTranslation method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\Translations::getTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslationFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/translation/en_GB');

		$this->object->getTranslation('joomla', 'joomla-platform', 'en_GB');
	}

	/**
	 * Tests the updateTranslation method with the content sent as a file
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationFile()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

		$this->assertEquals(
			$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', __DIR__ . '/stubs/source.ini', 'file'),
			json_decode($this->sampleString)
		);
	}


	/**
	 * Tests the updateTranslation method with the content sent as a string
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationString()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

		$this->assertEquals(
			$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateTranslation method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationFailure()
	{
		$this->prepareFailureTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

		$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"');
	}

	/**
	 * Tests the updateTranslation method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationBadType()
	{
		$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"', 'stuff');
	}
}

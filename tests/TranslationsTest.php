<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Translations;

/**
 * Test class for \BabDev\Transifex\Translations.
 */
class TranslationsTest extends TransifexTestCase
{
	/**
	 * Object being tested.
	 *
	 * @var  Translations
	 */
	private $object;

	/**
	 * {@inheritdoc}
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Translations($this->options, $this->client);
	}

	/**
	 * @testdox  getTranslation() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Translations::getTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslation()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/translation/en_GB?mode=default&file');

		$this->assertSame(
			$this->object->getTranslation('joomla', 'joomla-platform', 'en_GB', 'default'),
			$this->response
		);
	}

	/**
	 * @testdox  updateTranslation() with an attached file returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationFile()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

		$this->assertSame(
			$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', __DIR__ . '/stubs/source.ini', 'file'),
			$this->response
		);
	}


	/**
	 * @testdox  updateTranslation() with inline content returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @covers  \BabDev\Transifex\Translations::updateTranslation
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslationString()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/translation/en_GB');

		$this->assertSame(
			$this->object->updateTranslation('joomla', 'joomla-platform', 'en_GB', 'TEST="Test"'),
			$this->response
		);
	}

	/**
	 * @testdox  updateTranslation() throws an InvalidArgumentException when an invalid content type is specified
	 *
	 * @expectedException  \InvalidArgumentException
	 *
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

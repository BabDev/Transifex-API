<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Resources;

/**
 * Test class for \BabDev\Transifex\Resources.
 */
class ResourcesTest extends TransifexTestCase
{
	/**
	 * Object being tested.
	 *
	 * @var  Resources
	 */
	private $object;

	/**
	 * {@inheritdoc}
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Resources($this->options, $this->client);
	}

	/**
	 * @testdox  createResource() with inline content provided in the options returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::createResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateResourceContent()
	{
		$this->prepareSuccessTest('post', '/project/joomla-platform/resources/', 201);

		// Additional options
		$options = array(
		    'accept_translations' => true,
		    'category'            => 'whatever',
		    'priority'            => 3,
		    'content'             => 'Test="Test"'
		);

		$this->assertSame(
			$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', $options),
			$this->response
		);
	}

	/**
	 * @testdox  createResource() with an attached file in the options returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::createResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateResourceFile()
	{
		$this->prepareSuccessTest('post', '/project/joomla-platform/resources/', 201);

		// Additional options
		$options = array(
		    'accept_translations' => true,
		    'category'            => 'whatever',
		    'priority'            => 3,
		    'file'                => __DIR__ . '/stubs/source.ini'
		);

		$this->assertSame(
			$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', $options),
			$this->response
		);
	}

	/**
	 * @testdox  deleteResource() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::deleteResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteResource()
	{
		$this->prepareSuccessTest('delete', '/project/joomla/resource/joomla-platform', 204);

		$this->assertSame(
			$this->object->deleteResource('joomla', 'joomla-platform'),
			$this->response
		);
	}

	/**
	 * @testdox  getResource() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::getResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResource()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/?details');

		$this->assertSame(
			$this->object->getResource('joomla', 'joomla-platform', true),
			$this->response
		);
	}

	/**
	 * @testdox  getResourceContent() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::getResourceContent
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResourceContent()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/content/');

		$this->assertSame(
			$this->object->getResourceContent('joomla', 'joomla-platform'),
			$this->response
		);
	}

	/**
	 * @testdox  getResources() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::getResources
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResources()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resources');

		$this->assertSame(
			$this->object->getResources('joomla'),
			$this->response
		);
	}

	/**
	 * @testdox  updateResourceContent() with an attached file returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::updateResourceContent
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateResourceContentFile()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/content/');

		$this->assertSame(
			$this->object->updateResourceContent('joomla', 'joomla-platform', __DIR__ . '/stubs/source.ini', 'file'),
			$this->response
		);
	}


	/**
	 * @testdox  updateResourceContent() with inline content returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Resources::updateResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateResourceContentString()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/content/');

		$this->assertSame(
			$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"'),
			$this->response
		);
	}

	/**
	 * @testdox  updateResourceContent() throws an InvalidArgumentException when an invalid content type is specified
	 *
	 * @expectedException  \InvalidArgumentException
	 *
	 * @covers  \BabDev\Transifex\Resources::updateResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateResourceContentBadType()
	{
		$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"', 'stuff');
	}
}

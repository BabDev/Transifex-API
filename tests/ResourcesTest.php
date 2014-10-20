<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Resources;

/**
 * Test class for \BabDev\Transifex\Resources.
 *
 * @since  1.0
 */
class ResourcesTest extends TransifexTestCase
{
	/**
	 * @var    Resources  Object under test.
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

		$this->object = new Resources($this->options, $this->client);
	}

	/**
	 * Tests the createResource method with inline content
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::createResource
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
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

		$this->assertEquals(
			$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the createResource method with an attached file
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::createResource
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
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

		$this->assertEquals(
			$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the createResource method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::createResource
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateResourceFailure()
	{
		$this->prepareFailureTest('post', '/project/joomla-platform/resources/');

		$this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI', array('content' => 'Test="Test"'));
	}

	/**
	 * Tests the deleteResource method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::deleteResource
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteResource()
	{
		$this->prepareSuccessTest('delete', '/project/joomla/resource/joomla-platform', 204);

		$this->assertEquals(
			$this->object->deleteResource('joomla', 'joomla-platform'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the deleteResource method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::deleteResource
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteResourceFailure()
	{
		$this->prepareFailureTest('delete', '/project/joomla/resource/joomla-platform');

		$this->object->deleteResource('joomla', 'joomla-platform');
	}

	/**
	 * Tests the getResource method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::getResource
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResource()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/?details');

		$this->assertEquals(
			$this->object->getResource('joomla', 'joomla-platform', true),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getResource method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::getResource
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResourceFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/?details');

		$this->object->getResource('joomla', 'joomla-platform', true);
	}

	/**
	 * Tests the getResourceContent method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::getResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResourceContent()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resource/joomla-platform/content/');

		$this->assertEquals(
			$this->object->getResourceContent('joomla', 'joomla-platform'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getResourceContent method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::getResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResourceContentFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/content/');

		$this->object->getResourceContent('joomla', 'joomla-platform');
	}

	/**
	 * Tests the getResources method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::getResources
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResources()
	{
		$this->prepareSuccessTest('get', '/project/joomla/resources');

		$this->assertEquals(
			$this->object->getResources('joomla'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getResources method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::getResources
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetResourcesFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla/resources');

		$this->object->getResources('joomla');
	}

	/**
	 * Tests the updateResourceContent method with the content sent as a file
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::updateResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateResourceContentFile()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/content/');

		$this->assertEquals(
			$this->object->updateResourceContent('joomla', 'joomla-platform', __DIR__ . '/stubs/source.ini', 'file'),
			json_decode($this->sampleString)
		);
	}


	/**
	 * Tests the updateResourceContent method with the content sent as a string
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::updateResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateResourceContentString()
	{
		$this->prepareSuccessTest('put', '/project/joomla/resource/joomla-platform/content/');

		$this->assertEquals(
			$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateResourceContent method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::updateResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateResourceContentFailure()
	{
		$this->prepareFailureTest('put', '/project/joomla/resource/joomla-platform/content/');

		$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"');
	}

	/**
	 * Tests the updateResourceContent method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Resources::updateResourceContent
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @covers  \BabDev\Transifex\TransifexObject::updateResource
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateResourceContentBadType()
	{
		$this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"', 'stuff');
	}
}

<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Resources;

/**
 * Test class for \BabDev\Transifex\Resources.
 */
class ResourcesTest extends TransifexTestCase
{
    /**
     * @var Resources
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
     * @testdox createResource() with inline content provided in the options returns a Response object on a successful API connection
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
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'content'             => 'Test="Test"',
        ];

        $this->assertSame(
            $this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI',
                $options),
            $this->response
        );
    }

    /**
     * @testdox createResource() with an attached file in the options returns a Response object on a successful API connection
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
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'file'                => __DIR__ . '/stubs/source.ini',
        ];

        $this->assertSame(
            $this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI',
                $options),
            $this->response
        );
    }

    /**
     * @testdox createResource() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testCreateResourceFailure()
    {
        $this->prepareFailureTest('post', '/project/joomla-platform/resources/');

        $this->object->createResource('joomla-platform', 'Joomla Platform Data', 'joomla-platform', 'INI',
            ['content' => 'Test="Test"']);
    }

    /**
     * @testdox deleteResource() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::deleteResource
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
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
     * @testdox deleteResource() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::deleteResource
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testDeleteResourceFailure()
    {
        $this->prepareFailureTest('delete', '/project/joomla/resource/joomla-platform');

        $this->object->deleteResource('joomla', 'joomla-platform');
    }

    /**
     * @testdox getResource() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResource
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
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
     * @testdox getResource() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResource
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetResourceFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/?details');

        $this->object->getResource('joomla', 'joomla-platform', true);
    }

    /**
     * @testdox getResourceContent() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
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
     * @testdox getResourceContent() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetResourceContentFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla/resource/joomla-platform/content/');

        $this->object->getResourceContent('joomla', 'joomla-platform');
    }

    /**
     * @testdox getResources() returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResources
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
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
     * @testdox getResources() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResources
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testGetResourcesFailure()
    {
        $this->prepareFailureTest('get', '/project/joomla/resources');

        $this->object->getResources('joomla');
    }

    /**
     * @testdox updateResourceContent() with an attached file returns a Response object on a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
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
     * @testdox updateResourceContent() with inline content returns a Response object on a successful API connection
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

        $this->assertSame(
            $this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"'),
            $this->response
        );
    }

    /**
     * @testdox updateResourceContent() throws an UnexpectedResponseException on a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::processResponse
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \Joomla\Http\Exception\UnexpectedResponseException
     */
    public function testUpdateResourceContentFailure()
    {
        $this->prepareFailureTest('put', '/project/joomla/resource/joomla-platform/content/');

        $this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"');
    }

    /**
     * @testdox updateResourceContent() throws an InvalidArgumentException when an invalid content type is specified
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateResourceContentBadType()
    {
        $this->object->updateResourceContent('joomla', 'joomla-platform', 'TEST="Test"', 'stuff');
    }
}

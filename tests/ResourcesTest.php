<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Resources;

/**
 * Test class for \BabDev\Transifex\Resources.
 */
class ResourcesTest extends TransifexTestCase
{
    /**
     * @testdox createResource() with inline content provided in the options returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCreateResourceContent()
    {
        $this->prepareSuccessTest(201);

        // Additional options
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'content'             => 'Test="Test"',
        ];

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            $options
        );

        $this->validateSuccessTest('/api/2/project/babdev-transifex/resources/', 'POST', 201);
    }

    /**
     * @testdox createResource() with an attached file in the options returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCreateResourceFile()
    {
        $this->prepareSuccessTest(201);

        // Additional options
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'file'                => __DIR__ . '/stubs/source.ini',
        ];

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            $options
        );

        $this->validateSuccessTest('/api/2/project/babdev-transifex/resources/', 'POST', 201);
    }

    /**
     * @testdox createResource() with an attached file in the options that does not exist throws an InvalidArgumentException
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateResourceFileDoesNotExist()
    {
        // Additional options
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'file'                => __DIR__ . '/stubs/does-not-exist.ini',
        ];

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            $options
        );
    }

    /**
     * @testdox createResource() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testCreateResourceFailure()
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            ['content' => 'Test="Test"']
        );
    }

    /**
     * @testdox deleteResource() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::deleteResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testDeleteResource()
    {
        $this->prepareSuccessTest(204);

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteResource('babdev', 'babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex', 'DELETE', 204);
    }

    /**
     * @testdox deleteResource() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::deleteResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testDeleteResourceFailure()
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteResource('babdev', 'babdev-transifex');
    }

    /**
     * @testdox getResource() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetResource()
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResource('babdev', 'babdev-transifex', true);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'details',
            $request->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getResource() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResource
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetResourceFailure()
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResource('babdev', 'babdev-transifex', true);
    }

    /**
     * @testdox getResourceContent() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetResourceContent()
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResourceContent('babdev', 'babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/content/');
    }

    /**
     * @testdox getResourceContent() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetResourceContentFailure()
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResourceContent('babdev', 'babdev-transifex');
    }

    /**
     * @testdox getResources() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResources
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetResources()
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResources('babdev');

        $this->validateSuccessTest('/api/2/project/babdev/resources');
    }

    /**
     * @testdox getResources() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResources
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testGetResourcesFailure()
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResources('babdev');
    }

    /**
     * @testdox updateResourceContent() with an attached file returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateResourceContentFile()
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            __DIR__ . '/stubs/source.ini',
            'file'
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/content/', 'PUT');
    }

    /**
     * @testdox updateResourceContent() with inline content returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testUpdateResourceContentString()
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            'TEST="Test"'
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/content/', 'PUT');
    }

    /**
     * @testdox updateResourceContent() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testUpdateResourceContentFailure()
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent('babdev', 'babdev-transifex', 'TEST="Test"');
    }

    /**
     * @testdox updateResourceContent() throws an InvalidArgumentException when an invalid content type is specified
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateResourceContentBadType()
    {
        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            'TEST="Test"',
            'stuff'
        );
    }

    /**
     * @testdox updateResourceContent() throws an InvalidArgumentException when a non-existing file is specified
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\TransifexObject::updateResource
     *
     * @uses    \BabDev\Transifex\TransifexObject
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateResourceContentUnexistingFile()
    {
        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            __DIR__ . '/stubs/does-not-exist.ini',
            'file'
        );
    }
}

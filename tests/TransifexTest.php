<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Formats;
use BabDev\Transifex\Tests\Mock\Formats as MockFormats;
use BabDev\Transifex\Transifex;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Test class for \BabDev\Transifex\Transifex.
 */
class TransifexTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ClientInterface
     */
    private $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var Transifex
     */
    private $object;

    /**
     * @var array
     */
    private $options;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UriFactoryInterface
     */
    private $uriFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client         = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->streamFactory  = $this->createMock(StreamFactoryInterface::class);
        $this->uriFactory     = $this->createMock(UriFactoryInterface::class);
        $this->options        = ['api.username' => 'test', 'api.password' => 'test'];
        $this->object         = new Transifex($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options);
    }

    /**
     * @testdox get() throws an InvalidArgumentException for a non-existing object
     *
     * @covers  \BabDev\Transifex\Transifex::get
     *
     * @uses    \BabDev\Transifex\Transifex::getOption
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetFake()
    {
        $this->object->get('fake');
    }

    /**
     * @testdox get() with the "formats" parameter returns an instance of the Formats object
     *
     * @covers  \BabDev\Transifex\Transifex::get
     *
     * @uses    \BabDev\Transifex\Formats
     * @uses    \BabDev\Transifex\Transifex::__construct
     * @uses    \BabDev\Transifex\Transifex::getOption
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormats()
    {
        $this->assertInstanceOf(
            Formats::class,
            $this->object->get('formats')
        );
    }

    /**
     * @testdox get() with a custom namespace defined and the "formats" parameter returns an instance of the custom Formats object
     *
     * @covers  \BabDev\Transifex\Transifex::get
     *
     * @uses    \BabDev\Transifex\Formats
     * @uses    \BabDev\Transifex\Transifex::__construct
     * @uses    \BabDev\Transifex\Transifex::getOption
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormatsInCustomNamespace()
    {
        $this->object->setOption('object.namespace', __NAMESPACE__ . '\Mock');

        $this->assertInstanceOf(
            MockFormats::class,
            $this->object->get('formats')
        );
    }

    /**
     * @testdox get() with a custom namespace defined and the "formats" parameter and a class not found in the custom namespace returns an instance of the default Formats object
     *
     * @covers  \BabDev\Transifex\Transifex::get
     *
     * @uses    \BabDev\Transifex\Formats
     * @uses    \BabDev\Transifex\Transifex::__construct
     * @uses    \BabDev\Transifex\Transifex::getOption
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormatsInCustomNamespaceWhenNotFound()
    {
        $this->object->setOption('object.namespace', __NAMESPACE__);

        $this->assertInstanceOf(
            Formats::class,
            $this->object->get('formats')
        );
    }

    /**
     * @testdox get() with a custom namespace defined throws an InvalidArgumentException when the class is not found in either the custom or default namespace
     *
     * @covers  \BabDev\Transifex\Transifex::get
     *
     * @uses    \BabDev\Transifex\Transifex::getOption
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetFakeInCustomNamespaceWhenNotFound()
    {
        $this->object->setOption('object.namespace', __NAMESPACE__);
        $this->object->get('fake');
    }

    /**
     * @testdox getOption() and setOption() correctly manage the object's options
     *
     * @covers  \BabDev\Transifex\Transifex::getOption
     * @covers  \BabDev\Transifex\Transifex::setOption
     *
     * @uses    \BabDev\Transifex\Transifex::__construct
     */
    public function testSetAndGetOption()
    {
        $this->object->setOption('api.url', 'https://example.com/test');

        $this->assertAttributeContains('https://example.com/test', 'options', $this->object);

        $this->assertSame(
            $this->object->getOption('api.url'),
            'https://example.com/test'
        );
    }
}

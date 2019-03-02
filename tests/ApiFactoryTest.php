<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\ApiFactory;
use BabDev\Transifex\Formats;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Test class for \BabDev\Transifex\ApiFactory.
 */
class ApiFactoryTest extends TestCase
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
     * @var ApiFactory
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
        $this->object         = new ApiFactory($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory);
    }

    /**
     * @testdox get() throws an UnknownApiConnectorException for a non-existing object
     *
     * @expectedException \BabDev\Transifex\Exception\UnknownApiConnectorException
     */
    public function testGetFake()
    {
        $this->object->createApiConnector('fake');
    }

    /**
     * @testdox get() with the "formats" parameter returns an instance of the Formats object
     */
    public function testGetFormats()
    {
        $this->assertInstanceOf(
            Formats::class,
            $this->object->createApiConnector('formats')
        );
    }
}

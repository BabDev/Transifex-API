<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\FactoryInterface;
use BabDev\Transifex\Transifex;
use BabDev\Transifex\TransifexObject;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \BabDev\Transifex\Transifex.
 */
class TransifexTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|FactoryInterface
     */
    private $apiFactory;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Transifex
     */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->apiFactory = $this->createMock(FactoryInterface::class);
        $this->options    = ['api.username' => 'test', 'api.password' => 'test'];
        $this->object     = new Transifex($this->apiFactory, $this->options);
    }

    /**
     * @testdox get() returns an API connector
     */
    public function testGetFormats()
    {
        $this->apiFactory->expects($this->once())
            ->method('createApiConnector')
            ->willReturn($this->createMock(TransifexObject::class));

        $this->assertInstanceOf(
            TransifexObject::class,
            $this->object->get('formats')
        );
    }

    /**
     * @testdox getOption() and setOption() correctly manage the object's options
     */
    public function testSetAndGetOption()
    {
        $this->object->setOption('api.url', 'https://example.com/test');

        $this->assertSame(
            $this->object->getOption('api.url'),
            'https://example.com/test'
        );
    }
}

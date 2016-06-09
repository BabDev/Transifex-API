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

use BabDev\Transifex\{
    Formats, Http, Transifex
};

/**
 * Test class for \BabDev\Transifex\Transifex.
 */
class TransifexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Http
     */
    private $client;

    /**
     * @var Transifex
     */
    private $object;

    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->options = ['api.username' => 'test', 'api.password' => 'test'];
        $this->client  = $this->createMock(Http::class);
        $this->object  = new Transifex($this->options, $this->client);
    }

    /**
     * @testdox __construct() with no injected client creates a Transifex instance with a default Http object
     *
     * @covers  \BabDev\Transifex\Transifex::__construct
     * @covers  \BabDev\Transifex\Http::__construct
     * @uses    \BabDev\Transifex\Transifex::getOption
     * @uses    \BabDev\Transifex\Transifex::setOption
     */
    public function test__constructWithNoInjectedClient()
    {
        $object = new Transifex($this->options);

        $this->assertInstanceOf(
            Transifex::class,
            $object
        );

        $this->assertAttributeInstanceOf(
            Http::class,
            'client',
            $object
        );
    }

    /**
     * @testdox get() throws an InvalidArgumentException for a non-existing object
     *
     * @covers  \BabDev\Transifex\Transifex::get
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
     * @uses    \BabDev\Transifex\Formats
     * @uses    \BabDev\Transifex\Http
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
     * @uses    \BabDev\Transifex\Formats
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\Transifex::__construct
     * @uses    \BabDev\Transifex\Transifex::getOption
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormatsInCustomNamespace()
    {
        $this->object->setOption('object.namespace', 'BabDev\Transifex\Tests\Mock');

        $this->assertInstanceOf(
            '\BabDev\Transifex\Tests\Mock\Formats',
            $this->object->get('formats')
        );
    }

    /**
     * @testdox get() with a custom namespace defined and the "formats" parameter and a class not found in the custom namespace returns an instance of the default Formats object
     *
     * @covers  \BabDev\Transifex\Transifex::get
     * @uses    \BabDev\Transifex\Formats
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\Transifex::__construct
     * @uses    \BabDev\Transifex\Transifex::getOption
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testGetFormatsInCustomNamespaceWhenNotFound()
    {
        $this->object->setOption('object.namespace', 'BabDev\Transifex\Tests');

        $this->assertInstanceOf(
            Formats::class,
            $this->object->get('formats')
        );
    }

    /**
     * @testdox get() with a custom namespace defined throws an InvalidArgumentException when the class is not found in either the custom or default namespace
     *
     * @covers  \BabDev\Transifex\Transifex::get
     * @uses    \BabDev\Transifex\Transifex::getOption
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetFakeInCustomNamespaceWhenNotFound()
    {
        $this->object->setOption('object.namespace', 'BabDev\Transifex\Tests');
        $this->object->get('fake');
    }

    /**
     * @testdox getOption() and setOption() correctly manage the object's options
     *
     * @covers  \BabDev\Transifex\Transifex::getOption
     * @covers  \BabDev\Transifex\Transifex::setOption
     * @uses    \BabDev\Transifex\Http
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

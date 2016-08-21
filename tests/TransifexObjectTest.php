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

use BabDev\Transifex\Formats;
use BabDev\Transifex\TransifexObject;
use GuzzleHttp\Client;

/**
 * Test class for \BabDev\Transifex\TransifexObject.
 */
class TransifexObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Client
     */
    private $client;

    /**
     * @var TransifexObject
     */
    private $object;

    /**
     * @var array
     */
    private $options = [
        'base_url'     => 'http://www.transifex.com/api/2',
        'api.username' => 'MyTestUser',
        'api.password' => 'MyTestPass',
    ];

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client  = $this->createMock(Client::class);
        $this->object  = $this->getMockForAbstractClass(
            TransifexObject::class,
            [$this->options, $this->client]
        );
    }

    /**
     * @testdox __construct() with no injected client creates a Transifex instance with a default Client object
     *
     * @covers  \BabDev\Transifex\TransifexObject::__construct
     */
    public function test__constructWithNoInjectedClient()
    {
        $object = $this->getMockForAbstractClass(TransifexObject::class, [$this->options]);

        $this->assertInstanceOf(
            TransifexObject::class,
            $object
        );

        $this->assertAttributeInstanceOf(
            Client::class,
            'client',
            $object
        );
    }

    /**
     * @testdox The API does not connect when API credentials are not available
     *
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     * @covers  \BabDev\Transifex\TransifexObject::getOption
     *
     * @uses    \BabDev\Transifex\Formats
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Missing credentials for API authentication.
     */
    public function testApiFailureWhenNoAuthenticationIsSet()
    {
        (new Formats([], $this->client))->getFormats();
    }
}

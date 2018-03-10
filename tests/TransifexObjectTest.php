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
class TransifexObjectTest extends TransifexTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client = $this->createMock(Client::class);
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

    /**
     * @testdox When a custom base URL is set in the options the API request goes to that URL
     *
     * @covers  \BabDev\Transifex\Statistics::getStatistics
     * @covers  \BabDev\Transifex\TransifexObject::getAuthData
     *
     * @uses    \BabDev\Transifex\TransifexObject
     */
    public function testCustomBaseUrlIsUsed()
    {
        $this->prepareSuccessTest();

        $this->options['base_url'] = 'https://api.transifex.com';

        (new Formats($this->options, $this->client))->getFormats();

        $this->validateSuccessTest('/api/2/formats');

        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->historyContainer[0]['request'];

        $this->assertSame(
            'api.transifex.com',
            $request->getUri()->getHost(),
            'The API did not use the right host.'
        );
    }
}

<?php declare(strict_types=1);

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
        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, []))->getFormats();
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

        $this->options['base_uri'] = 'https://api.transifex.com';

        (new Formats($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getFormats();

        $this->validateSuccessTest('/api/2/formats');

        $this->assertSame(
            'api.transifex.com',
            $this->client->getRequest()->getUri()->getHost(),
            'The API did not use the right host.'
        );
    }
}

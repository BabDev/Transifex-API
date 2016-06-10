<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex;

use GuzzleHttp\Client;
use Joomla\Http\Exception\UnexpectedResponseException;
use Joomla\Http\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API object class.
 */
abstract class TransifexObject
{
    /**
     * Options for the Transifex object.
     *
     * @var array
     */
    protected $options;

    /**
     * The HTTP client object to use in sending HTTP requests.
     *
     * @var Client
     */
    protected $client;

    /**
     * @param array  $options Transifex options array.
     * @param Client $client  The HTTP client object.
     */
    public function __construct(array $options = [], Client $client = null)
    {
        $this->options = $options;
        $this->client  = $client ?: new Client($this->options);
    }

    /**
     * Get the authentication credentials for the API request.
     *
     * @return array
     *
     * @throws \InvalidArgumentException if credentials are not set
     */
    protected function getAuthData() : array
    {
        $username = $this->getOption('api.username');
        $password = $this->getOption('api.password');

        // The API requires HTTP Basic Authentication, we can't proceed without credentials
        if ($username === null || $password === null) {
            throw new \InvalidArgumentException('Missing credentials for API authentication.');
        }

        return [$username, $password];
    }

    /**
     * Get an option from the options store.
     *
     * @param string $key     The name of the option to get.
     * @param mixed  $default The default value if the option is not set.
     *
     * @return mixed The option value.
     */
    protected function getOption($key, $default = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }

    /**
     * Method to update an API endpoint with resource content.
     *
     * @param string $path    API path
     * @param string $content The content of the resource.  This can either be a string of data or a file path.
     * @param string $type    The type of content in the $content variable.  This should be either string or file.
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    protected function updateResource($path, $content, $type)
    {
        // Verify the content type is allowed
        if (!in_array($type, ['string', 'file'])) {
            throw new \InvalidArgumentException('The content type must be specified as file or string.');
        }

        $data = [
            'content' => ($type == 'string') ? $content : file_get_contents($content),
        ];

        // Send the request.
        return $this->processResponse(
            $this->client->put(
                $this->fetchUrl($path),
                json_encode($data),
                ['Content-Type' => 'application/json']
            )
        );
    }
}

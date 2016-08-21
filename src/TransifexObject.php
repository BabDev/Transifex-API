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
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

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
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param array           $options Transifex options array
     * @param ClientInterface $client  The HTTP client object
     */
    public function __construct(array $options = [], ClientInterface $client = null)
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
     * @param string $key     The name of the option to get
     * @param mixed  $default The default value if the option is not set
     *
     * @return mixed The option value
     */
    protected function getOption(string $key, $default = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }

    /**
     * Update an API endpoint with resource content.
     *
     * @param UriInterface $uri     URI object representing the API path to request
     * @param string       $content The content of the resource, this can either be a string of data or a file path
     * @param string       $type    The type of content in the $content variable, this should be either string or file
     *
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function updateResource(UriInterface $uri, string $content, string $type) : ResponseInterface
    {
        // Verify the content type is allowed
        if (!in_array($type, ['string', 'file'])) {
            throw new \InvalidArgumentException('The content type must be specified as file or string.');
        }

        if ($type == 'file') {
            if (!file_exists($content)) {
                throw new \InvalidArgumentException(
                    sprintf('The specified file, "%s", does not exist.', $content)
                );
            }

            $content = file_get_contents($content);
        }

        $data = [
            'content' => $content,
        ];

        return $this->client->request(
            'PUT',
            $uri,
            [
                'body'    => json_encode($data),
                'auth'    => $this->getAuthData(),
                'headers' => ['Content-Type' => 'application/json'],
            ]
        );
    }
}

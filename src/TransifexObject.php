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

use Joomla\Http\Exception\UnexpectedResponseException;
use Joomla\Http\Response;

/**
 * Transifex API object class.
 */
abstract class TransifexObject
{
    /**
     * Options for the Transifex object.
     *
     * @var array|\ArrayAccess
     */
    protected $options;

    /**
     * The HTTP client object to use in sending HTTP requests.
     *
     * @var Http
     */
    protected $client;

    /**
     * @param array|\ArrayAccess $options Transifex options array.
     * @param Http               $client  The HTTP client object.
     */
    public function __construct($options = [], Http $client = null)
    {
        if (!is_array($options) && !($options instanceof \ArrayAccess)) {
            throw new \InvalidArgumentException(
                'The options param must be an array or implement the ArrayAccess interface.'
            );
        }

        $this->options = $options;
        $this->client  = isset($client) ? $client : new Http($this->options);
    }

    /**
     * Method to build and return a full request URL for the request.
     *
     * This method will add appropriate pagination details if necessary and also prepend the API URL
     * to have a complete URL for the request.
     *
     * @param string $path URL to inflect
     *
     * @return string
     */
    protected function fetchUrl($path)
    {
        // Ensure the API URL is set before moving on
        $base = isset($this->options['api.url']) ? $this->options['api.url'] : '';

        return $base . $path;
    }

    /**
     * Process the response and return it.
     *
     * @param Response $response     The response.
     * @param int      $expectedCode The expected response code.
     *
     * @return Response
     *
     * @throws UnexpectedResponseException
     */
    protected function processResponse(Response $response, $expectedCode = 200)
    {
        // Validate the response code.
        if ($response->code != $expectedCode) {
            // Decode the error response and throw an exception.
            $error = json_decode($response->body);

            // Check if the error message is set; send a generic one if not
            $message = isset($error->message) ? $error->message : $response->body;

            throw new UnexpectedResponseException($response, $message, $response->code);
        }

        return $response;
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

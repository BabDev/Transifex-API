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

/**
 * Base class for interacting with the Transifex API.
 */
class Transifex
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
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($options = [], Http $client = null)
    {
        if (!is_array($options) && !($options instanceof \ArrayAccess)) {
            throw new \InvalidArgumentException(
                'The options param must be an array or implement the ArrayAccess interface.'
            );
        }

        $this->options = $options;

        // Set the Authorization header if we have credentials
        if ($this->getOption('api.username') && $this->getOption('api.password')) {
            $headers = [
                'Authorization' => 'Basic ' . base64_encode($this->getOption('api.username') . ':'
                        . $this->getOption('api.password')),
            ];

            $this->setOption('headers', $headers);
        }

        $this->client = isset($client) ? $client : new Http($this->options);

        // Setup the default API url if not already set.
        if (!$this->getOption('api.url')) {
            $this->setOption('api.url', 'https://www.transifex.com/api/2');
        }
    }

    /**
     * Factory method to fetch API objects.
     *
     * @param string $name Name of the API object to retrieve.
     *
     * @return TransifexObject
     *
     * @throws \InvalidArgumentException
     */
    public function get($name)
    {
        $namespace = $this->getOption('object.namespace', __NAMESPACE__);
        $class     = $namespace . '\\' . ucfirst(strtolower($name));

        if (class_exists($class)) {
            return new $class($this->options, $this->client);
        }

        // If a custom namespace was specified, let's try to find an object in the local namespace
        if ($namespace !== __NAMESPACE__) {
            $class = __NAMESPACE__ . '\\' . ucfirst(strtolower($name));

            if (class_exists($class)) {
                return new $class($this->options, $this->client);
            }
        }

        // No class found, sorry!
        throw new \InvalidArgumentException("Could not find an API object for '$name'.");
    }

    /**
     * Get an option from the Transifex instance.
     *
     * @param string $key     The name of the option to get.
     * @param mixed  $default The default value if the option is not set.
     *
     * @return mixed The option value.
     */
    public function getOption($key, $default = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }

    /**
     * Set an option for the Transifex instance.
     *
     * @param string $key   The name of the option to set.
     * @param mixed  $value The option value to set.
     *
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }
}

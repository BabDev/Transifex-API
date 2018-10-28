<?php declare(strict_types=1);

namespace BabDev\Transifex;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Base class for interacting with the Transifex API.
 */
class Transifex
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

        // Setup the default API url if not already set.
        if (!$this->getOption('base_uri')) {
            $this->setOption('base_uri', 'https://www.transifex.com');
        }

        $this->client = $client ?: new Client($this->options);
    }

    /**
     * Factory method to fetch API objects.
     *
     * @param string $name Name of the API object to retrieve
     *
     * @return TransifexObject
     *
     * @throws \InvalidArgumentException
     */
    public function get(string $name): TransifexObject
    {
        $namespace = \rtrim($this->getOption('object.namespace', __NAMESPACE__), '\\');
        $class     = $namespace . '\\' . \ucfirst(\strtolower($name));

        if (\class_exists($class)) {
            return new $class($this->options, $this->client);
        }

        // If a custom namespace was specified, let's try to find an object in the local namespace
        if ($namespace !== __NAMESPACE__) {
            $class = __NAMESPACE__ . '\\' . \ucfirst(\strtolower($name));

            if (\class_exists($class)) {
                return new $class($this->options, $this->client);
            }
        }

        // No class found, sorry!
        throw new \InvalidArgumentException("Could not find an API object for '$name'.");
    }

    /**
     * Get an option from the Transifex instance.
     *
     * @param string $key     The name of the option to get
     * @param mixed  $default The default value if the option is not set
     *
     * @return mixed The option value
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Set an option for the Transifex instance.
     *
     * @param string $key   The name of the option to set
     * @param mixed  $value The option value to set
     *
     * @return $this
     */
    public function setOption(string $key, $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }
}

<?php declare(strict_types=1);

namespace BabDev\Transifex;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Base class for interacting with the Transifex API.
 */
class Transifex
{
    /**
     * The request factory.
     *
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * The URI factory.
     *
     * @var UriFactoryInterface
     */
    protected $uriFactory;

    /**
     * Options for the Transifex object.
     *
     * @var array
     */
    protected $options;

    /**
     * @param RequestFactoryInterface $requestFactory The request factory
     * @param UriFactoryInterface     $uriFactory     The URI factory
     * @param array                   $options        Transifex options array
     */
    public function __construct(RequestFactoryInterface $requestFactory, UriFactoryInterface $uriFactory, array $options = [])
    {
        $this->requestFactory = $requestFactory;
        $this->uriFactory     = $uriFactory;
        $this->options        = $options;

        // Setup the default API url if not already set.
        if (!$this->getOption('base_uri')) {
            $this->setOption('base_uri', 'https://www.transifex.com');
        }
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
            return new $class($this->requestFactory, $this->uriFactory, $this->options);
        }

        // If a custom namespace was specified, let's try to find an object in the local namespace
        if ($namespace !== __NAMESPACE__) {
            $class = __NAMESPACE__ . '\\' . \ucfirst(\strtolower($name));

            if (\class_exists($class)) {
                return new $class($this->requestFactory, $this->uriFactory, $this->options);
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

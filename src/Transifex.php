<?php declare(strict_types=1);

namespace BabDev\Transifex;

/**
 * Base class for interacting with the Transifex API.
 */
final class Transifex implements TransifexInterface
{
    /**
     * The API factory.
     *
     * @var FactoryInterface
     */
    private $apiFactory;

    /**
     * Options for the API client.
     *
     * @var array
     */
    private $options;

    /**
     * @param FactoryInterface $apiFactory The API factory
     * @param array            $options    Transifex options array
     */
    public function __construct(FactoryInterface $apiFactory, array $options = [])
    {
        $this->apiFactory = $apiFactory;
        $this->options    = $options;

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
     * @return ApiConnector
     *
     * @throws Exception\UnknownApiConnectorException
     */
    public function get(string $name): ApiConnector
    {
        return $this->apiFactory->createApiConnector($name, $this->options);
    }

    /**
     * Get an option from the API client.
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
     * Set an option for the API client.
     *
     * @param string $key   The name of the option to set
     * @param mixed  $value The option value to set
     *
     * @return void
     */
    public function setOption(string $key, $value): void
    {
        $this->options[$key] = $value;
    }
}

<?php declare(strict_types=1);

namespace BabDev\Transifex;

/**
 * Interface defining a Transifex API client.
 */
interface TransifexInterface
{
    /**
     * Factory method to fetch API objects.
     *
     * @param string $name Name of the API object to retrieve
     *
     * @return ApiConnector
     *
     * @throws Exception\UnknownApiConnectorException
     */
    public function get(string $name): ApiConnector;

    /**
     * Get an option from the API client.
     *
     * @param string $key     The name of the option to get
     * @param mixed  $default The default value if the option is not set
     *
     * @return mixed The option value
     */
    public function getOption(string $key, $default = null);

    /**
     * Set an option for the API client.
     *
     * @param string $key   The name of the option to set
     * @param mixed  $value The option value to set
     *
     * @return void
     */
    public function setOption(string $key, $value): void;
}

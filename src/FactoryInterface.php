<?php declare(strict_types=1);

namespace BabDev\Transifex;

/**
 * Interface defining a factory responsible for creating Transifex API objects.
 */
interface FactoryInterface
{
    /**
     * Factory method to create API connectors.
     *
     * @param string $name    Name of the API object to retrieve
     * @param array  $options Transifex options array
     *
     * @return ApiConnector
     *
     * @throws \InvalidArgumentException
     */
    public function createApiConnector(string $name, array $options = []): ApiConnector;
}

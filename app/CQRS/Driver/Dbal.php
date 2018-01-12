<?php

/**
 * @date    2018-01-12
 * @file    Dbal.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\CQRS\Driver;

use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class Dbal /*implements Driver*/
{
    /**
     * @var \Illuminate\Config\Repository
     */
    private $config;

    public function __construct()
    {
        $this->config = app(\Illuminate\Config\Repository::class);
    }

    /**
     * @return object
     */
    public function getDriver()
    {
        $configuration = new Configuration();
        $connectionParams = $this->getStorageConnectionParameters();
        $connection = DriverManager::getConnection($connectionParams, $configuration);

        app()->singleton(\Doctrine\DBAL\Connection::class, function () use ($connection) {
            return $connection;
        });

        $connection = app(\Doctrine\DBAL\Connection::class);
        $payloadSerializer = app(\Broadway\Serializer\Serializer::class);
        $metadataSerializer = app(\Broadway\Serializer\Serializer::class);
        $binaryUuidConverter = app(\Broadway\UuidGenerator\Converter\BinaryUuidConverter::class);

        $table = $this->config->get('broadway.event-store.table', 'event_store');

        return new DBALEventStore($connection, $payloadSerializer, $metadataSerializer, $table, false, $binaryUuidConverter);
    }

    /**
     * Make a connection parameters array based on the laravel configuration
     * @return array
     */
    private function getStorageConnectionParameters()
    {
        $driver = $this->config->get('database.default');
        $connectionParams = $this->config->get("database.connections.{$driver}");

        if ('sqlite' === $driver || 'testing' === $driver) {
            $connectionParams['path'] = $connectionParams['database'];
        } else {
            $connectionParams['dbname'] = $connectionParams['database'];
            $connectionParams['user'] = $connectionParams['username'];
        }

        unset($connectionParams['database'], $connectionParams['username']);
        $connectionParams['driver'] = "pdo_".$connectionParams['driver'];

        return $connectionParams;
    }
}

<?php


namespace Factory;


use Client\BaseApiClient;


class ClientFactory
{
    public static function make(string $apiName, array $config): BaseApiClient
    {
        $className = 'Client\\' . $apiName . 'ApiClient';
        if (class_exists($className)) {
            return new $className($config);
        }

        return new BaseApiClient($config);
    }
}

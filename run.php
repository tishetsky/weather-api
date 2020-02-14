<?php

$config = require_once __DIR__ . '/config.php';

$locations = [
    [
        'coords' => '55.0101,72.0202',
        'format' => 'json',
    ],
    [
        'coords' => [
            55.3232, 72.4545
        ],
        'format' => 'xml',
    ],
];

foreach ($config['api'] as $apiName => $apiConfig) {
    $apiClient = Factory\ClientFactory::make($apiName, $apiConfig);

    foreach ($locations as $location) {
        try {
            $apiClient->setCoords($location['coords']);
            $apiClient->setProcessor(Factory\ProcessorFactory::make($location['format'], $config));
            $apiClient->getResponse();
        } catch (\Exception $e) {
            print "Failed to get data for {$apiName}: {$e->getMessage()}\n";
        }
    }
}

print "===\nMessage log:\n" . implode("\n", \Logger::getInstance()->getMessages()) . "\n\n";

<?php

require_once __DIR__ . '/app/Base/BaseObject.php';
require_once __DIR__ . '/app/Client/BaseApiClient.php';
require_once __DIR__ . '/app/Client/DarkSkyApiClient.php';
require_once __DIR__ . '/app/Factory/ClientFactory.php';
require_once __DIR__ . '/app/Factory/ProcessorFactory.php';
require_once __DIR__ . '/app/Processor/AbstractProcessor.php';
require_once __DIR__ . '/app/Processor/JsonProcessor.php';
require_once __DIR__ . '/app/Processor/XmlProcessor.php';
require_once __DIR__ . '/app/Logger.php';

return [
    'api' => [
        'DarkSky' => [
            'api_key' => '8d643cfc5f868eb3fd3c33f9349f08f5',
            'api_url' => 'https://api.darksky.net/forecast/:key/:latitude,:longitude?units=si&exclude=minutely,hourly,daily,alerts,flags',
            'response_fields' => [
                'date' => 'time',
                'wind_speed' => 'windSpeed',
                'wind_direction' => 'windBearing',
            ],
        ],
    ],
    'formats' => [
        'xml' => [
            'datadir' => __DIR__ . '/data/xml',
            'write_file' => true,
            'fields_order' => [
                'date',
                'wind_speed',
                'temperature',
            ],
        ],
        'json' => [
            'datadir' => __DIR__ . '/data/json',
            'write_file' => true,
            'fields_order' => [
                'date',
                'temperature',
                'wind_direction',
            ],
        ],
    ],
];

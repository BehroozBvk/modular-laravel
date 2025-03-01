<?php

declare(strict_types=1);

return [
    'name' => 'Country',

    'api' => [
        'base_url' => env('COUNTRIES_API_BASE_URL', 'https://restcountries.com/v3.1'),
        'fields' => env('COUNTRIES_API_FIELDS', 'name,flags'),
        'chunk_size' => env('COUNTRIES_API_CHUNK_SIZE', 100),
        'timeout' => env('COUNTRIES_API_TIMEOUT', 30),
        'retry_times' => env('COUNTRIES_API_RETRY_TIMES', 3),
        'retry_sleep' => env('COUNTRIES_API_RETRY_SLEEP', 1000), // milliseconds
    ],
];

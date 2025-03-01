<?php

declare(strict_types=1);

return [
    'api' => [
        'base_url' => env('COUNTRIES_API_BASE_URL', 'https://restcountries.com/v3.1'),
        'fields' => env('COUNTRIES_API_FIELDS', 'name,flags'),
    ],
];

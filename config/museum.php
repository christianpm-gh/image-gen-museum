<?php

return [
    'currency' => env('MUSEUM_CURRENCY', 'MXN'),

    'pricing' => [
        'standard' => (int) env('MUSEUM_STANDARD_PRICE', 199),
        'premium' => (int) env('MUSEUM_PREMIUM_PRICE', 349),
    ],

    'catalog_disk' => env('MUSEUM_CATALOG_DISK', 'museum_catalog'),
    'generated_disk' => env('MUSEUM_GENERATED_DISK', 'generated_memories'),
    'ticket_link_ttl_hours' => (int) env('MUSEUM_TICKET_LINK_TTL_HOURS', 168),
];

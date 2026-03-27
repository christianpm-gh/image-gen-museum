<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'museum_catalog' => [
            'driver' => env('MUSEUM_CATALOG_DRIVER', 'public'),
            'root' => env('MUSEUM_CATALOG_DRIVER', 'public') === 's3'
                ? ''
                : storage_path('app/public/museum-catalog'),
            'url' => env('MUSEUM_CATALOG_DRIVER', 'public') === 's3'
                ? env('MUSEUM_CATALOG_URL')
                : env('APP_URL').'/storage/museum-catalog',
            'visibility' => 'public',
            'throw' => false,
            'key' => env('SUPABASE_STORAGE_KEY', env('AWS_ACCESS_KEY_ID')),
            'secret' => env('SUPABASE_STORAGE_SECRET', env('AWS_SECRET_ACCESS_KEY')),
            'region' => env('SUPABASE_STORAGE_REGION', env('AWS_DEFAULT_REGION', 'us-east-1')),
            'bucket' => env('SUPABASE_CATALOG_BUCKET', env('AWS_BUCKET')),
            'endpoint' => env('SUPABASE_STORAGE_ENDPOINT', env('AWS_ENDPOINT')),
            'use_path_style_endpoint' => env('SUPABASE_USE_PATH_STYLE_ENDPOINT', true),
            'http' => [
                'verify' => env('SUPABASE_STORAGE_VERIFY', false),
            ],
        ],

        'generated_memories' => [
            'driver' => env('MUSEUM_GENERATED_DRIVER', 'public'),
            'root' => env('MUSEUM_GENERATED_DRIVER', 'public') === 's3'
                ? ''
                : storage_path('app/public/generated-memories'),
            'url' => env('MUSEUM_GENERATED_DRIVER', 'public') === 's3'
                ? env('MUSEUM_GENERATED_URL')
                : env('APP_URL').'/storage/generated-memories',
            'visibility' => env('MUSEUM_GENERATED_VISIBILITY', 'public'),
            'throw' => false,
            'key' => env('SUPABASE_STORAGE_KEY', env('AWS_ACCESS_KEY_ID')),
            'secret' => env('SUPABASE_STORAGE_SECRET', env('AWS_SECRET_ACCESS_KEY')),
            'region' => env('SUPABASE_STORAGE_REGION', env('AWS_DEFAULT_REGION', 'us-east-1')),
            'bucket' => env('SUPABASE_GENERATED_BUCKET', env('AWS_BUCKET')),
            'endpoint' => env('SUPABASE_STORAGE_ENDPOINT', env('AWS_ENDPOINT')),
            'use_path_style_endpoint' => env('SUPABASE_USE_PATH_STYLE_ENDPOINT', true),
            'http' => [
                'verify' => env('SUPABASE_STORAGE_VERIFY', false),
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Horizon Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Horizon will be accessible from. If this
    | setting is null, Horizon will reside under the same domain as the
    | application. Otherwise, this value will serve as the subdomain.
    |
    */

    'domain' => env('HORIZON_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Horizon Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Horizon will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths "itself" only Horizon's root URI.
    |
    */

    'path' => env('HORIZON_PATH', 'horizon'),

    /*
    |--------------------------------------------------------------------------
    | Horizon Storage Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default storage driver that will be used to
    | store Horizon's meta and failed job data. In addition, you may set
    | the Redis connection that will be used to store these metrics.
    |
    */

    'storage' => [
        'driver' => env('HORIZON_STORAGE_DRIVER', 'redis'),
        'redis' => env('HORIZON_REDIS_CONNECTION', 'horizon'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the Redis connections that will be used by
    | Horizon to process jobs. Each connection has its own workers and
    | can be configured with separate supervisors and settings.
    |
    */

    'redis' => [
        'cluster' => env('HORIZON_REDIS_CLUSTER', 'redis'),
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', '6379'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => env('HORIZON_REDIS_DB', '0'),
        ],
        'horizon' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', '6379'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => env('HORIZON_REDIS_DB', '1'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Wait Times
    |--------------------------------------------------------------------------
    |
    | Here you may configure the maximum "wait time" for each queue before
    | the worker will loop back around and continue processing jobs. This
    | is useful for throttling job processing on certain queues.
    |
    */

    'waits' => [
        'redis:default' => 60,
        'redis:high' => 30,
        'redis:low' => 120,
        'redis:notifications' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Worker Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the number of workers that will process jobs, how
    | many seconds each worker should pause before processing the next job,
    | and maximum jobs per worker before it will be recycled.
    |
    */

    'defaults' => [
        'supervisor-1' => [
            'connection' => 'redis',
            'queue' => 'default',
            'balance' => 'auto',
            'maxProcesses' => 4,
            'minProcesses' => 1,
            'maxTime' => 60,
            'maxJobs' => 0,
            'memory' => 128,
            'tries' => 3,
            'timeout' => 60,
            'sleep' => 3,
            'stopOnFail' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Supervisor Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may define which "supervisors" will be running. A supervisor
    | is a collection of workers that manage the processing of jobs for
    | each queue. Each supervisor may have multiple workers to process.
    |
    */

    'supervisors' => [
        'orders-supervisor' => [
            'connection' => 'redis',
            'queue' => ['orders', 'high'],
            'balance' => 'simple',
            'maxProcesses' => 5,
            'minProcesses' => 2,
            'maxTime' => 3600,
            'maxJobs' => 1000,
            'memory' => 256,
            'tries' => 3,
            'timeout' => 300,
        ],

        'notifications-supervisor' => [
            'connection' => 'redis',
            'queue' => ['notifications', 'email', 'sms', 'whatsapp'],
            'balance' => 'auto',
            'maxProcesses' => 3,
            'minProcesses' => 1,
            'maxTime' => 1800,
            'maxJobs' => 500,
            'memory' => 128,
            'tries' => 3,
            'timeout' => 120,
        ],

        'scheduled-supervisor' => [
            'connection' => 'redis',
            'queue' => ['scheduled', 'reports'],
            'balance' => 'simple',
            'maxProcesses' => 2,
            'minProcesses' => 1,
            'maxTime' => 3600,
            'maxJobs' => 100,
            'memory' => 256,
            'tries' => 3,
            'timeout' => 600,
        ],

        'default-supervisor' => [
            'connection' => 'redis',
            'queue' => ['default', 'low'],
            'balance' => 'auto',
            'maxProcesses' => 3,
            'minProcesses' => 1,
            'maxTime' => 1800,
            'maxJobs' => 500,
            'memory' => 128,
            'tries' => 3,
            'timeout' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Metrics
    |--------------------------------------------------------------------------
    |
    | Here you may configure the metrics that Horizon will collect. The
    | "metrics" are stored in Redis and used to display insights about
    | the processing of jobs over time.
    |
    */

    'metrics' => [
        'driver' => env('HORIZON_METRICS_DRIVER', 'redis'),
        'sampleRate' => env('HORIZON_SAMPLE_RATE', 1.0),
        'retention' => env('HORIZON_METRICS_RETENTION', 10080), // 1 week
    ],

    /*
    |--------------------------------------------------------------------------
    | Trending Jobs
    |--------------------------------------------------------------------------
    |
    | Here you may configure which jobs will be considered "trending" by
    | Horizon. These jobs will be highlighted in the dashboard's trending
    | section. You may specify which jobs to track and threshold.
    |
    */

    'trending' => [
        'limit' => 50,
        'threshold' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tags
    |--------------------------------------------------------------------------
    |
    | Here you may configure which job tags will be tracked by Horizon.
    | These tags will be displayed in the dashboard to help you track
    | which jobs are being processed with which tags.
    |
    */

    'tags' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Fair Dispatching
    |--------------------------------------------------------------------------
    |
    | This option allows Horizon to use "fair" job dispatching. This
    | ensures that each worker processes the same number of jobs as
    | other workers regardless of how long each job takes.
    |
    */

    'fairDispatching' => [
        'enabled' => true,
    ],
];

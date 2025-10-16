<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for performance optimization
    | including caching, database optimization, and monitoring settings.
    |
    */

    'cache' => [
        'enabled' => env('PERFORMANCE_CACHE_ENABLED', true),
        'default_ttl' => env('PERFORMANCE_CACHE_TTL', 3600), // 1 hour
        'keys' => [
            'homepage_setting_active' => 3600, // 1 hour
            'homepage_statistics' => 1800, // 30 minutes
            'homepage_latest_news' => 900, // 15 minutes
            'homepage_featured_news' => 1800, // 30 minutes
            'admin_news_stats' => 300, // 5 minutes
            'news_categories' => 3600, // 1 hour
            'news_popular' => 1800, // 30 minutes
            'news_recent' => 900, // 15 minutes
            'news_popular_tags' => 3600, // 1 hour
            'extracurriculars_featured' => 1800, // 30 minutes
            'extracurriculars_categories' => 3600, // 1 hour
            'galleries_featured' => 1800, // 30 minutes
            'about_facilities' => 1800, // 30 minutes
            'about_achievements' => 1800, // 30 minutes
            'about_statistics' => 1800, // 30 minutes
        ],
    ],

    'database' => [
        'optimization' => [
            'enabled' => env('DB_OPTIMIZATION_ENABLED', true),
            'auto_optimize' => env('DB_AUTO_OPTIMIZE', false),
            'optimize_interval' => env('DB_OPTIMIZE_INTERVAL', 24), // hours
        ],
        'indexes' => [
            'enabled' => env('DB_INDEXES_ENABLED', true),
            'auto_create' => env('DB_AUTO_CREATE_INDEXES', false),
        ],
        'query_logging' => [
            'enabled' => env('DB_QUERY_LOGGING_ENABLED', false),
            'slow_query_threshold' => env('DB_SLOW_QUERY_THRESHOLD', 100), // milliseconds
        ],
    ],

    'monitoring' => [
        'enabled' => env('PERFORMANCE_MONITORING_ENABLED', true),
        'slow_request_threshold' => env('PERFORMANCE_SLOW_REQUEST_THRESHOLD', 1000), // milliseconds
        'high_memory_threshold' => env('PERFORMANCE_HIGH_MEMORY_THRESHOLD', 50), // MB
        'high_query_threshold' => env('PERFORMANCE_HIGH_QUERY_THRESHOLD', 20),
        'log_slow_requests' => env('PERFORMANCE_LOG_SLOW_REQUESTS', true),
        'log_high_memory' => env('PERFORMANCE_LOG_HIGH_MEMORY', true),
        'log_high_queries' => env('PERFORMANCE_LOG_HIGH_QUERIES', true),
    ],

    'assets' => [
        'optimization' => [
            'enabled' => env('ASSET_OPTIMIZATION_ENABLED', true),
            'minify_css' => env('ASSET_MINIFY_CSS', true),
            'minify_js' => env('ASSET_MINIFY_JS', true),
            'compress_images' => env('ASSET_COMPRESS_IMAGES', true),
        ],
        'lazy_loading' => [
            'enabled' => env('ASSET_LAZY_LOADING_ENABLED', true),
            'threshold' => env('ASSET_LAZY_LOADING_THRESHOLD', 3), // Skip first N images
        ],
        'preloading' => [
            'enabled' => env('ASSET_PRELOADING_ENABLED', true),
            'critical_resources' => [
                '/css/app.css',
                '/js/app.js',
                '/images/logo.png',
            ],
        ],
    ],

    'compression' => [
        'enabled' => env('COMPRESSION_ENABLED', true),
        'gzip' => env('COMPRESSION_GZIP', true),
        'brotli' => env('COMPRESSION_BROTLI', false),
        'min_compression_size' => env('COMPRESSION_MIN_SIZE', 1024), // bytes
    ],

    'cdn' => [
        'enabled' => env('CDN_ENABLED', false),
        'url' => env('CDN_URL', ''),
        'assets' => [
            'css' => env('CDN_CSS', false),
            'js' => env('CDN_JS', false),
            'images' => env('CDN_IMAGES', false),
        ],
    ],

    'headers' => [
        'cache_control' => [
            'enabled' => env('HEADERS_CACHE_CONTROL_ENABLED', true),
            'static_assets' => 'public, max-age=31536000', // 1 year
            'html' => 'public, max-age=3600', // 1 hour
            'api' => 'no-cache, no-store, must-revalidate',
        ],
        'security' => [
            'enabled' => env('HEADERS_SECURITY_ENABLED', true),
            'x_frame_options' => 'DENY',
            'x_content_type_options' => 'nosniff',
            'x_xss_protection' => '1; mode=block',
        ],
    ],

    'alerts' => [
        'enabled' => env('PERFORMANCE_ALERTS_ENABLED', false),
        'email' => env('PERFORMANCE_ALERTS_EMAIL', ''),
        'thresholds' => [
            'slow_requests' => env('ALERT_SLOW_REQUESTS_THRESHOLD', 5), // per hour
            'high_memory' => env('ALERT_HIGH_MEMORY_THRESHOLD', 3), // per hour
            'high_queries' => env('ALERT_HIGH_QUERIES_THRESHOLD', 10), // per hour
        ],
    ],

    'maintenance' => [
        'enabled' => env('PERFORMANCE_MAINTENANCE_ENABLED', false),
        'schedule' => env('PERFORMANCE_MAINTENANCE_SCHEDULE', '0 2 * * *'), // Daily at 2 AM
        'tasks' => [
            'clear_old_caches' => true,
            'optimize_database' => true,
            'clean_logs' => true,
            'update_statistics' => true,
        ],
    ],
];





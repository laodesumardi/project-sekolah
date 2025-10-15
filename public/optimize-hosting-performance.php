<?php
/**
 * Optimize Hosting Performance
 * 
 * This script optimizes the project for hosting performance
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/optimize-hosting-performance.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('OPTIMIZE_PERFORMANCE_PASSWORD', 'optimize-hosting-performance-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== OPTIMIZE_PERFORMANCE_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h1>Optimize Hosting Performance</h1>";
echo "<p>Optimizing project performance for hosting...</p>";

// Check current directory
$currentDir = getcwd();
echo "<h2>Current Directory</h2>";
echo "<p><strong>Current Directory:</strong> $currentDir</p>";

// Function to create optimized .htaccess
function createOptimizedHtaccess() {
    echo "<h3>Creating Optimized .htaccess</h3>";
    
    $htaccessContent = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"
</IfModule>

# Cache Control for Static Assets
<IfModule mod_expires.c>
    ExpiresActive On
    
    # Images
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/x-icon "access plus 1 year"
    
    # CSS and JavaScript
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType application/x-javascript "access plus 1 month"
    
    # Fonts
    ExpiresByType font/woff "access plus 1 year"
    ExpiresByType font/woff2 "access plus 1 year"
    ExpiresByType application/font-woff "access plus 1 year"
    ExpiresByType application/font-woff2 "access plus 1 year"
    
    # Documents
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType application/msword "access plus 1 month"
    ExpiresByType application/vnd.openxmlformats-officedocument.wordprocessingml.document "access plus 1 month"
</IfModule>

# Gzip Compression
<IfModule mod_deflate.c>
    # Compress HTML, CSS, JavaScript, Text, XML and fonts
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
    AddOutputFilterByType DEFLATE application/x-font
    AddOutputFilterByType DEFLATE application/x-font-opentype
    AddOutputFilterByType DEFLATE application/x-font-otf
    AddOutputFilterByType DEFLATE application/x-font-truetype
    AddOutputFilterByType DEFLATE application/x-font-ttf
    AddOutputFilterByType DEFLATE application/x-javascript
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE font/opentype
    AddOutputFilterByType DEFLATE font/otf
    AddOutputFilterByType DEFLATE font/ttf
    AddOutputFilterByType DEFLATE image/svg+xml
    AddOutputFilterByType DEFLATE image/x-icon
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/xml
    
    # Remove browser bugs (only needed for really old browsers)
    BrowserMatch ^Mozilla/4 gzip-only-text/html
    BrowserMatch ^Mozilla/4\.0[678] no-gzip
    BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
    Header append Vary User-Agent
</IfModule>

# Browser Caching
<IfModule mod_headers.c>
    <FilesMatch "\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$">
        Header set Cache-Control "max-age=31536000, public"
    </FilesMatch>
    
    <FilesMatch "\.(html|htm|php)$">
        Header set Cache-Control "max-age=3600, public"
    </FilesMatch>
</IfModule>

# MIME Types
<IfModule mod_mime.c>
    AddType application/font-woff .woff
    AddType application/font-woff2 .woff2
    AddType application/vnd.ms-fontobject .eot
    AddType font/opentype .otf
    AddType font/truetype .ttf
    AddType image/svg+xml .svg
    AddType image/webp .webp
</IfModule>

# Prevent access to sensitive files
<FilesMatch "\.(env|log|ini|conf|sql|bak|backup|old|tmp)$">
    Order Deny,Allow
    Deny from all
</FilesMatch>

# Prevent directory listing
Options -Indexes

# Remove server signature
ServerTokens Prod
ServerSignature Off';

    if (file_put_contents('public/.htaccess', $htaccessContent)) {
        echo "<p style='color: green;'>✅ Optimized .htaccess created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create optimized .htaccess</p>";
    }
}

// Function to create storage .htaccess
function createStorageHtaccess() {
    echo "<h3>Creating Storage .htaccess</h3>";
    
    $storageHtaccess = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /storage/
    RewriteRule ^(.*)$ ../storage/app/public/$1 [L,QSA]
</IfModule>

# Allow access to all files
<Files "*">
    Order Allow,Deny
    Allow from all
</Files>

# File access permissions for images
<FilesMatch "\.(jpg|jpeg|png|gif|svg|webp|ico|pdf|doc|docx|xls|xlsx|txt|zip)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Prevent access to sensitive files
<FilesMatch "\.(php|php3|php4|php5|phtml|pl|py|jsp|asp|sh|cgi)$">
    Order Deny,Allow
    Deny from all
</FilesMatch>

# Prevent directory listing
Options -Indexes

# Cache control for images
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/svg+xml "access plus 1 month"
    ExpiresByType image/webp "access plus 1 month"
    ExpiresByType image/x-icon "access plus 1 month"
</IfModule>

# Compression for images
<IfModule mod_deflate.c>
    # Don\'t compress images (they\'re already compressed)
    SetEnvIfNoCase Request_URI \
        \.(?:gif|jpe?g|png|svg|webp|ico)$ no-gzip dont-vary
</IfModule>';

    if (file_put_contents('public/storage/.htaccess', $storageHtaccess)) {
        echo "<p style='color: green;'>✅ Storage .htaccess created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create storage .htaccess</p>";
    }
}

// Function to create optimized Vite config
function createOptimizedViteConfig() {
    echo "<h3>Creating Optimized Vite Config</h3>";
    
    $viteConfig = 'import { defineConfig } from \'vite\';
import laravel from \'laravel-vite-plugin\';

export default defineConfig({
    plugins: [
        laravel({
            input: [\'resources/css/app.css\', \'resources/js/app.js\'],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: [\'axios\', \'alpinejs\'],
                    admin: [\'datatables\', \'sweetalert2\'],
                },
            },
        },
        cssCodeSplit: true,
        sourcemap: false,
        minify: \'terser\',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
    },
    server: {
        hmr: {
            host: \'localhost\',
        },
    },
});';

    if (file_put_contents('vite.config.js', $viteConfig)) {
        echo "<p style='color: green;'>✅ Optimized Vite config created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create optimized Vite config</p>";
    }
}

// Function to create optimized package.json
function createOptimizedPackageJson() {
    echo "<h3>Creating Optimized Package.json</h3>";
    
    $packageJson = '{
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "build:prod": "vite build --mode production",
        "dev": "vite",
        "preview": "vite preview"
    },
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.2",
        "alpinejs": "^3.4.2",
        "autoprefixer": "^10.4.2",
        "axios": "^1.7.4",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^1.2.0",
        "postcss": "^8.4.31",
        "tailwindcss": "^3.1.0",
        "vite": "^6.0.11",
        "terser": "^5.24.0"
    }
}';

    if (file_put_contents('package.json', $packageJson)) {
        echo "<p style='color: green;'>✅ Optimized package.json created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create optimized package.json</p>";
    }
}

// Function to create performance monitoring
function createPerformanceMonitoring() {
    echo "<h3>Creating Performance Monitoring</h3>";
    
    $monitoringContent = '<?php
/**
 * Performance Monitoring
 * 
 * This file contains performance monitoring configurations
 */

// Performance monitoring configuration
$performanceConfig = [
    \'enabled\' => env(\'PERFORMANCE_MONITORING\', true),
    \'slow_query_threshold\' => 1000, // milliseconds
    \'memory_threshold\' => 128, // MB
    \'cache_hit_ratio_threshold\' => 0.8,
];

// Database query monitoring
function monitorDatabaseQueries($query, $time) {
    if ($time > $performanceConfig[\'slow_query_threshold\']) {
        Log::warning(\'Slow query detected\', [
            \'query\' => $query,
            \'time\' => $time,
            \'memory\' => memory_get_usage(true),
        ]);
    }
}

// Memory usage monitoring
function monitorMemoryUsage() {
    $memoryUsage = memory_get_usage(true) / 1024 / 1024; // MB
    
    if ($memoryUsage > $performanceConfig[\'memory_threshold\']) {
        Log::warning(\'High memory usage detected\', [
            \'memory_usage\' => $memoryUsage,
            \'threshold\' => $performanceConfig[\'memory_threshold\'],
        ]);
    }
}

// Cache performance monitoring
function monitorCachePerformance($cacheKey, $hit) {
    $cacheStats = Cache::get(\'cache_stats\', []);
    
    if (!isset($cacheStats[$cacheKey])) {
        $cacheStats[$cacheKey] = [\'hits\' => 0, \'misses\' => 0];
    }
    
    if ($hit) {
        $cacheStats[$cacheKey][\'hits\']++;
    } else {
        $cacheStats[$cacheKey][\'misses\']++;
    }
    
    Cache::put(\'cache_stats\', $cacheStats, 3600);
}

// Performance reporting
function generatePerformanceReport() {
    $report = [
        \'timestamp\' => now(),
        \'memory_usage\' => memory_get_usage(true),
        \'peak_memory\' => memory_get_peak_usage(true),
        \'execution_time\' => microtime(true) - $_SERVER[\'REQUEST_TIME_FLOAT\'],
        \'cache_stats\' => Cache::get(\'cache_stats\', []),
    ];
    
    return $report;
}';

    if (file_put_contents('performance-monitoring.php', $monitoringContent)) {
        echo "<p style='color: green;'>✅ Performance monitoring created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create performance monitoring</p>";
    }
}

// Function to create database optimizations
function createDatabaseOptimizations() {
    echo "<h3>Creating Database Optimizations</h3>";
    
    $optimizationContent = '<?php
/**
 * Database Performance Optimizations
 * 
 * This file contains database optimization configurations
 */

// Database connection optimizations
$databaseConfig = [
    \'connections\' => [
        \'mysql\' => [
            \'driver\' => \'mysql\',
            \'host\' => env(\'DB_HOST\', \'127.0.0.1\'),
            \'port\' => env(\'DB_PORT\', \'3306\'),
            \'database\' => env(\'DB_DATABASE\', \'forge\'),
            \'username\' => env(\'DB_USERNAME\', \'forge\'),
            \'password\' => env(\'DB_PASSWORD\', \'\'),
            \'unix_socket\' => env(\'DB_SOCKET\', \'\'),
            \'charset\' => \'utf8mb4\',
            \'collation\' => \'utf8mb4_unicode_ci\',
            \'prefix\' => \'\',
            \'strict\' => true,
            \'engine\' => null,
            \'options\' => [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            ],
        ],
    ],
];

// Query optimization tips
$queryOptimizations = [
    \'Use indexes on frequently queried columns\',
    \'Use eager loading to prevent N+1 queries\',
    \'Use database transactions for bulk operations\',
    \'Cache frequently accessed data\',
    \'Use database views for complex queries\',
    \'Optimize database schema\',
    \'Use connection pooling\',
    \'Monitor slow queries\',
];

// Cache configuration
$cacheConfig = [
    \'default\' => \'redis\',
    \'stores\' => [
        \'redis\' => [
            \'driver\' => \'redis\',
            \'connection\' => \'cache\',
        ],
        \'database\' => [
            \'driver\' => \'database\',
            \'table\' => \'cache\',
            \'connection\' => null,
        ],
    ],
];';

    if (file_put_contents('database-optimizations.php', $optimizationContent)) {
        echo "<p style='color: green;'>✅ Database optimizations created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create database optimizations</p>";
    }
}

// Function to create test files
function createTestFiles() {
    echo "<h3>Creating Test Files</h3>";
    
    // Create test image
    $testImageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
    
    if (file_put_contents('storage/app/public/test-image.jpg', $testImageData)) {
        echo "<p style='color: green;'>✅ Test image created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create test image</p>";
    }
    
    // Create test text file
    if (file_put_contents('storage/app/public/test.txt', 'Test file for storage access')) {
        echo "<p style='color: green;'>✅ Test text file created</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create test text file</p>";
    }
}

// Run all optimizations
echo "<h2>Running All Performance Optimizations</h2>";

// 1. Create optimized .htaccess
createOptimizedHtaccess();

// 2. Create storage .htaccess
createStorageHtaccess();

// 3. Create optimized Vite config
createOptimizedViteConfig();

// 4. Create optimized package.json
createOptimizedPackageJson();

// 5. Create performance monitoring
createPerformanceMonitoring();

// 6. Create database optimizations
createDatabaseOptimizations();

// 7. Create test files
createTestFiles();

echo "<h2>Performance Optimization Complete!</h2>";
echo "<p><strong>Optimizations Applied:</strong></p>";
echo "<ul>";
echo "<li>✅ Optimized .htaccess files created</li>";
echo "<li>✅ Storage .htaccess created</li>";
echo "<li>✅ Optimized Vite config created</li>";
echo "<li>✅ Optimized package.json created</li>";
echo "<li>✅ Performance monitoring created</li>";
echo "<li>✅ Database optimizations created</li>";
echo "<li>✅ Test files created</li>";
echo "</ul>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Run <code>npm run build:prod</code> to build optimized assets</li>";
echo "<li>Clear Laravel caches: <code>php artisan cache:clear</code></li>";
echo "<li>Test storage access with: <a href='/storage/test.txt'>/storage/test.txt</a></li>";
echo "<li>Test image access with: <a href='/storage/test-image.jpg'>/storage/test-image.jpg</a></li>";
echo "<li>Delete this file for security</li>";
echo "</ol>";

echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Optimize Hosting Performance</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 1000px; margin: 0 auto; }
        h1, h2, h3 { color: #333; }
        ul, ol { margin-left: 20px; }
        li { margin-bottom: 10px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
</body>
</html>

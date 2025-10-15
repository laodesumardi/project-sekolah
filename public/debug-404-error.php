<?php
/**
 * Debug 404 Error - Page Not Found
 * 
 * This script helps debug 404 errors and missing pages
 * Use this to identify what's causing the "This Page Does Not Exist" error
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/debug-404-error.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('DEBUG_404_PASSWORD', 'debug-404-error-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== DEBUG_404_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h2>Debug 404 Error - Page Not Found</h2>";
echo "<p>Debugging 404 errors and missing pages...</p>";

// Get current URL and server information
$currentUrl = $_SERVER['REQUEST_URI'] ?? '';
$documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

echo "<h3>Server Information</h3>";
echo "<p><strong>Current URL:</strong> $currentUrl</p>";
echo "<p><strong>Document Root:</strong> $documentRoot</p>";
echo "<p><strong>Script Name:</strong> $scriptName</p>";
echo "<p><strong>Request Method:</strong> " . ($_SERVER['REQUEST_METHOD'] ?? 'Unknown') . "</p>";

// Check Laravel project structure
echo "<h3>Laravel Project Structure Check</h3>";

$requiredFiles = [
    'artisan',
    'composer.json',
    'app/Http/Controllers',
    'routes/web.php',
    'public/index.php',
    'storage/app/public',
    'bootstrap/app.php'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ Found: $file</p>";
    } else {
        echo "<p style='color: red;'>❌ Missing: $file</p>";
    }
}

// Check public directory structure
echo "<h3>Public Directory Structure</h3>";

$publicFiles = [
    'public/index.php',
    'public/.htaccess',
    'public/storage',
    'public/css',
    'public/js',
    'public/images'
];

foreach ($publicFiles as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ Found: $file</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Missing: $file</p>";
    }
}

// Check .htaccess files
echo "<h3>.htaccess Files Check</h3>";

$htaccessFiles = [
    'public/.htaccess',
    'public/storage/.htaccess',
    'storage/.htaccess',
    'storage/app/public/.htaccess'
];

foreach ($htaccessFiles as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ Found: $file</p>";
        
        // Check if .htaccess is readable
        if (is_readable($file)) {
            echo "<p style='color: green;'>✅ Readable: $file</p>";
        } else {
            echo "<p style='color: red;'>❌ Not readable: $file</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Missing: $file</p>";
    }
}

// Check Laravel routes
echo "<h3>Laravel Routes Check</h3>";

if (file_exists('routes/web.php')) {
    $routesContent = file_get_contents('routes/web.php');
    
    // Check for common routes
    $commonRoutes = [
        'Route::get(\'/\'',
        'Route::get(\'/home\'',
        'Route::get(\'/about\'',
        'Route::get(\'/contact\'',
        'Route::get(\'/ppdb\'',
        'Route::get(\'/admin\''
    ];
    
    foreach ($commonRoutes as $route) {
        if (strpos($routesContent, $route) !== false) {
            echo "<p style='color: green;'>✅ Found route: $route</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Missing route: $route</p>";
        }
    }
} else {
    echo "<p style='color: red;'>❌ routes/web.php not found</p>";
}

// Check Laravel configuration
echo "<h3>Laravel Configuration Check</h3>";

if (file_exists('.env')) {
    echo "<p style='color: green;'>✅ .env file exists</p>";
    
    // Check important environment variables
    $envContent = file_get_contents('.env');
    $importantVars = [
        'APP_NAME',
        'APP_ENV',
        'APP_DEBUG',
        'APP_URL',
        'DB_CONNECTION',
        'DB_HOST',
        'DB_DATABASE'
    ];
    
    foreach ($importantVars as $var) {
        if (strpos($envContent, $var) !== false) {
            echo "<p style='color: green;'>✅ Found: $var</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Missing: $var</p>";
        }
    }
} else {
    echo "<p style='color: red;'>❌ .env file not found</p>";
}

// Check storage permissions
echo "<h3>Storage Permissions Check</h3>";

$storageDirs = [
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/logs',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache'
];

foreach ($storageDirs as $dir) {
    if (file_exists($dir)) {
        if (is_writable($dir)) {
            echo "<p style='color: green;'>✅ Writable: $dir</p>";
        } else {
            echo "<p style='color: red;'>❌ Not writable: $dir</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Missing: $dir</p>";
    }
}

// Check for common 404 causes
echo "<h3>Common 404 Causes Check</h3>";

// Check if index.php exists and is accessible
if (file_exists('public/index.php')) {
    echo "<p style='color: green;'>✅ public/index.php exists</p>";
    
    // Check if index.php is readable
    if (is_readable('public/index.php')) {
        echo "<p style='color: green;'>✅ public/index.php is readable</p>";
    } else {
        echo "<p style='color: red;'>❌ public/index.php is not readable</p>";
    }
} else {
    echo "<p style='color: red;'>❌ public/index.php not found</p>";
}

// Check if .htaccess exists in public
if (file_exists('public/.htaccess')) {
    echo "<p style='color: green;'>✅ public/.htaccess exists</p>";
    
    // Check .htaccess content
    $htaccessContent = file_get_contents('public/.htaccess');
    if (strpos($htaccessContent, 'RewriteEngine On') !== false) {
        echo "<p style='color: green;'>✅ RewriteEngine is enabled</p>";
    } else {
        echo "<p style='color: red;'>❌ RewriteEngine not found in .htaccess</p>";
    }
} else {
    echo "<p style='color: red;'>❌ public/.htaccess not found</p>";
}

// Check for error logs
echo "<h3>Error Logs Check</h3>";

$logFiles = [
    'storage/logs/laravel.log',
    'storage/logs/error.log',
    'storage/logs/debug.log'
];

foreach ($logFiles as $logFile) {
    if (file_exists($logFile)) {
        echo "<p style='color: green;'>✅ Found: $logFile</p>";
        
        // Check log file size
        $logSize = filesize($logFile);
        if ($logSize > 0) {
            echo "<p style='color: orange;'>⚠️ Log file has content: $logFile ($logSize bytes)</p>";
        } else {
            echo "<p style='color: green;'>✅ Log file is empty: $logFile</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Missing: $logFile</p>";
    }
}

// Provide solutions
echo "<h3>Solutions</h3>";
echo "<ol>";
echo "<li><strong>Check .htaccess file:</strong><br>";
echo "Make sure public/.htaccess exists and contains proper rewrite rules<br><br>";
echo "</li>";

echo "<li><strong>Check Laravel routes:</strong><br>";
echo "Make sure routes/web.php contains the routes you're trying to access<br><br>";
echo "</li>";

echo "<li><strong>Check Laravel configuration:</strong><br>";
echo "Make sure .env file exists and contains proper configuration<br><br>";
echo "</li>";

echo "<li><strong>Check storage permissions:</strong><br>";
echo "Make sure storage directories are writable<br><br>";
echo "</li>";

echo "<li><strong>Check error logs:</strong><br>";
echo "Check storage/logs/laravel.log for detailed error information<br><br>";
echo "</li>";

echo "<li><strong>Clear Laravel cache:</strong><br>";
echo "Run: php artisan cache:clear<br>";
echo "Run: php artisan config:clear<br>";
echo "Run: php artisan route:clear<br><br>";
echo "</li>";

echo "<li><strong>Check web server configuration:</strong><br>";
echo "Make sure web server is configured to serve Laravel application<br>";
echo "Check if mod_rewrite is enabled for Apache<br><br>";
echo "</li>";
echo "</ol>";

echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug 404 Error</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 1000px; margin: 0 auto; }
        h2, h3 { color: #333; }
        ol, ul { margin-left: 20px; }
        li { margin-bottom: 10px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
</body>
</html>

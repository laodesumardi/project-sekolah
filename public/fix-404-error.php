<?php
/**
 * Fix 404 Error - Page Not Found
 * 
 * This script fixes common 404 errors in Laravel applications
 * Use this to fix "This Page Does Not Exist" errors
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/fix-404-error.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('FIX_404_PASSWORD', 'fix-404-error-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== FIX_404_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h2>Fix 404 Error - Page Not Found</h2>";
echo "<p>Fixing common 404 errors in Laravel application...</p>";

// Check current directory
$currentDir = getcwd();
echo "<h3>Current Directory</h3>";
echo "<p><strong>Current Directory:</strong> $currentDir</p>";

// Check if we're in Laravel project root
if (!file_exists('artisan') || !file_exists('composer.json')) {
    echo "<p style='color: red;'>❌ Not in Laravel project root. Please navigate to Laravel project directory.</p>";
    exit;
}

echo "<p style='color: green;'>✅ In Laravel project root</p>";

// Fix 1: Check and create .htaccess file
echo "<h3>1. Fixing .htaccess File</h3>";

$htaccessPath = 'public/.htaccess';
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
</IfModule>';

if (file_exists($htaccessPath)) {
    echo "<p style='color: green;'>✅ .htaccess file exists</p>";
    
    // Check if .htaccess has correct content
    $currentContent = file_get_contents($htaccessPath);
    if (strpos($currentContent, 'RewriteEngine On') !== false) {
        echo "<p style='color: green;'>✅ .htaccess has correct content</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ .htaccess needs to be updated</p>";
        if (file_put_contents($htaccessPath, $htaccessContent)) {
            echo "<p style='color: green;'>✅ .htaccess updated successfully</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to update .htaccess</p>";
        }
    }
} else {
    echo "<p style='color: orange;'>⚠️ .htaccess file not found, creating...</p>";
    if (file_put_contents($htaccessPath, $htaccessContent)) {
        echo "<p style='color: green;'>✅ .htaccess created successfully</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create .htaccess</p>";
    }
}

// Fix 2: Check and create index.php
echo "<h3>2. Fixing index.php File</h3>";

$indexPath = 'public/index.php';
if (file_exists($indexPath)) {
    echo "<p style='color: green;'>✅ index.php exists</p>";
    
    // Check if index.php has correct content
    $indexContent = file_get_contents($indexPath);
    if (strpos($indexContent, 'require __DIR__') !== false) {
        echo "<p style='color: green;'>✅ index.php has correct content</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ index.php needs to be updated</p>";
    }
} else {
    echo "<p style='color: red;'>❌ index.php not found</p>";
    echo "<p>Please check your Laravel installation.</p>";
}

// Fix 3: Check Laravel routes
echo "<h3>3. Checking Laravel Routes</h3>";

if (file_exists('routes/web.php')) {
    echo "<p style='color: green;'>✅ routes/web.php exists</p>";
    
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
    
    $foundRoutes = 0;
    foreach ($commonRoutes as $route) {
        if (strpos($routesContent, $route) !== false) {
            echo "<p style='color: green;'>✅ Found route: $route</p>";
            $foundRoutes++;
        }
    }
    
    if ($foundRoutes == 0) {
        echo "<p style='color: red;'>❌ No common routes found in routes/web.php</p>";
    }
} else {
    echo "<p style='color: red;'>❌ routes/web.php not found</p>";
}

// Fix 4: Check Laravel configuration
echo "<h3>4. Checking Laravel Configuration</h3>";

if (file_exists('.env')) {
    echo "<p style='color: green;'>✅ .env file exists</p>";
    
    $envContent = file_get_contents('.env');
    
    // Check important environment variables
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
    echo "<p>Please create .env file from .env.example</p>";
}

// Fix 5: Check storage permissions
echo "<h3>5. Fixing Storage Permissions</h3>";

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
        if (chmod($dir, 0755)) {
            echo "<p style='color: green;'>✅ Fixed permissions for: $dir</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to fix permissions for: $dir</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Directory not found: $dir</p>";
    }
}

// Fix 6: Check for error logs
echo "<h3>6. Checking Error Logs</h3>";

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
            
            // Show last few lines of log
            $logLines = file($logFile);
            $lastLines = array_slice($logLines, -5);
            echo "<p><strong>Last 5 lines of $logFile:</strong></p>";
            echo "<pre style='background: #f4f4f4; padding: 10px; border-radius: 5px;'>";
            foreach ($lastLines as $line) {
                echo htmlspecialchars($line);
            }
            echo "</pre>";
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
echo "<li><strong>Clear Laravel cache:</strong><br>";
echo "Run these commands in terminal:<br>";
echo "<code>php artisan cache:clear</code><br>";
echo "<code>php artisan config:clear</code><br>";
echo "<code>php artisan route:clear</code><br>";
echo "<code>php artisan view:clear</code><br><br>";
echo "</li>";

echo "<li><strong>Check web server configuration:</strong><br>";
echo "Make sure web server is configured to serve Laravel application<br>";
echo "Check if mod_rewrite is enabled for Apache<br>";
echo "Check if URL rewriting is enabled for Nginx<br><br>";
echo "</li>";

echo "<li><strong>Check Laravel routes:</strong><br>";
echo "Make sure routes/web.php contains the routes you're trying to access<br>";
echo "Check if route names and URLs are correct<br><br>";
echo "</li>";

echo "<li><strong>Check Laravel configuration:</strong><br>";
echo "Make sure .env file exists and contains proper configuration<br>";
echo "Check if APP_URL is set correctly<br>";
echo "Check if APP_DEBUG is set to true for debugging<br><br>";
echo "</li>";

echo "<li><strong>Check storage permissions:</strong><br>";
echo "Make sure storage directories are writable<br>";
echo "Run: <code>chmod -R 755 storage/</code><br>";
echo "Run: <code>chmod -R 755 bootstrap/cache/</code><br><br>";
echo "</li>";

echo "<li><strong>Check error logs:</strong><br>";
echo "Check storage/logs/laravel.log for detailed error information<br>";
echo "Look for specific error messages that might indicate the problem<br><br>";
echo "</li>";

echo "<li><strong>Test Laravel application:</strong><br>";
echo "Try accessing: <code>https://yourdomain.com/</code><br>";
echo "Try accessing: <code>https://yourdomain.com/home</code><br>";
echo "Try accessing: <code>https://yourdomain.com/about</code><br><br>";
echo "</li>";
echo "</ol>";

echo "<h3>Quick Fix Commands</h3>";
echo "<p>Run these commands in terminal to fix common issues:</p>";
echo "<pre style='background: #f4f4f4; padding: 15px; border-radius: 5px;'>";
echo "php artisan cache:clear\n";
echo "php artisan config:clear\n";
echo "php artisan route:clear\n";
echo "php artisan view:clear\n";
echo "php artisan config:cache\n";
echo "php artisan route:cache\n";
echo "php artisan view:cache\n";
echo "chmod -R 755 storage/\n";
echo "chmod -R 755 bootstrap/cache/\n";
echo "</pre>";

echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix 404 Error</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 1000px; margin: 0 auto; }
        h2, h3 { color: #333; }
        ol, ul { margin-left: 20px; }
        li { margin-bottom: 10px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
</body>
</html>

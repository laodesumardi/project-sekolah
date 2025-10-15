<?php
/**
 * Fix 403 Forbidden Error for Storage
 * 
 * This script fixes 403 Forbidden errors for storage images
 * Use this on shared hosting where permissions need to be set
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/fix-403-error.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('FIX_403_PASSWORD', 'fix-403-error-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== FIX_403_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h2>Fix 403 Forbidden Error for Storage</h2>";
echo "<p>Fixing 403 Forbidden errors for storage images...</p>";

// Define paths
$documentRoot = $_SERVER['DOCUMENT_ROOT'];
$storagePath = $documentRoot . '/storage';
$appPublicPath = $documentRoot . '/storage/app/public';

echo "<h3>Path Information</h3>";
echo "<p><strong>Document Root:</strong> $documentRoot</p>";
echo "<p><strong>Storage Path:</strong> $storagePath</p>";
echo "<p><strong>App Public Path:</strong> $appPublicPath</p>";

// Check if storage directory exists
if (!file_exists($storagePath)) {
    echo "<p style='color: red;'>❌ Storage directory does not exist: $storagePath</p>";
    echo "<p>Please check your Laravel installation.</p>";
    exit;
}

echo "<p style='color: green;'>✅ Storage directory exists: $storagePath</p>";

// Check if app/public directory exists
if (!file_exists($appPublicPath)) {
    echo "<p style='color: red;'>❌ App public directory does not exist: $appPublicPath</p>";
    echo "<p>Please check your Laravel installation.</p>";
    exit;
}

echo "<p style='color: green;'>✅ App public directory exists: $appPublicPath</p>";

// Fix permissions for storage directory
echo "<h3>Fixing Permissions</h3>";

$directories = [
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

foreach ($directories as $dir) {
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

// Fix permissions for files in storage/app/public
if (file_exists('storage/app/public')) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator('storage/app/public'),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($files as $file) {
        if ($file->isFile()) {
            if (chmod($file->getPathname(), 0644)) {
                echo "<p style='color: green;'>✅ Fixed permissions for: " . $file->getPathname() . "</p>";
            } else {
                echo "<p style='color: red;'>❌ Failed to fix permissions for: " . $file->getPathname() . "</p>";
            }
        }
    }
}

// Create .htaccess files if they don't exist
echo "<h3>Creating .htaccess Files</h3>";

$htaccessFiles = [
    'storage/.htaccess' => 'storage/.htaccess',
    'storage/app/public/.htaccess' => 'storage/app/public/.htaccess',
    'public/storage/.htaccess' => 'public/storage/.htaccess'
];

foreach ($htaccessFiles as $file => $path) {
    if (!file_exists($path)) {
        echo "<p style='color: orange;'>⚠️ .htaccess file not found: $path</p>";
        echo "<p>Please upload the .htaccess files manually.</p>";
    } else {
        echo "<p style='color: green;'>✅ .htaccess file exists: $path</p>";
    }
}

// Test storage access
echo "<h3>Testing Storage Access</h3>";

// Test if storage directory is accessible
if (is_readable('storage/app/public')) {
    echo "<p style='color: green;'>✅ Storage directory is readable</p>";
} else {
    echo "<p style='color: red;'>❌ Storage directory is not readable</p>";
}

// Test if we can create files in storage
$testFile = 'storage/app/public/test-access.txt';
if (file_put_contents($testFile, 'test')) {
    echo "<p style='color: green;'>✅ Can write to storage directory</p>";
    unlink($testFile); // Clean up
} else {
    echo "<p style='color: red;'>❌ Cannot write to storage directory</p>";
}

// Test specific URLs
echo "<h3>Testing Specific URLs</h3>";

$testUrls = [
    'storage/images/placeholder-image.jpg',
    'storage/about-page/principal.jpg',
    'storage/achievements/trophy.jpg'
];

foreach ($testUrls as $url) {
    if (file_exists($url)) {
        echo "<p style='color: green;'>✅ File exists: $url</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ File not found: $url</p>";
    }
}

echo "<h3>Manual Steps Required</h3>";
echo "<ol>";
echo "<li><strong>Upload .htaccess files:</strong><br>";
echo "Upload the following .htaccess files to your hosting:<br>";
echo "- storage/.htaccess<br>";
echo "- storage/app/public/.htaccess<br>";
echo "- public/storage/.htaccess<br><br>";
echo "</li>";

echo "<li><strong>Set proper permissions:</strong><br>";
echo "Set the following permissions via cPanel or FTP:<br>";
echo "- storage/ → 755<br>";
echo "- storage/app/ → 755<br>";
echo "- storage/app/public/ → 755<br>";
echo "- All files in storage/app/public/ → 644<br><br>";
echo "</li>";

echo "<li><strong>Test access:</strong><br>";
echo "Test access to: https://odetune.shop/storage/images/your-image.jpg<br>";
echo "Should return HTTP 200 OK instead of 403 Forbidden<br>";
echo "</li>";
echo "</ol>";

echo "<h3>Alternative Solutions</h3>";
echo "<ol>";
echo "<li><strong>Contact Hosting Support:</strong><br>";
echo "Ask them to fix storage permissions or enable symlink() function<br><br>";
echo "</li>";

echo "<li><strong>Use ImageHelper Class:</strong><br>";
echo "Use the ImageHelper class which handles fallback images automatically<br>";
echo "No additional configuration needed if using ImageHelper::getImageUrl()<br><br>";
echo "</li>";

echo "<li><strong>Copy Files Method:</strong><br>";
echo "Copy files from storage/app/public/ to public/storage/ manually<br>";
echo "⚠️ Note: You'll need to copy files every time you upload new images<br>";
echo "</li>";
echo "</ol>";

echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix 403 Forbidden Error</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        h2, h3 { color: #333; }
        ol, ul { margin-left: 20px; }
        li { margin-bottom: 10px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
</body>
</html>

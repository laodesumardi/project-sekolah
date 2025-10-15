<?php
/**
 * Storage Permissions Fix Script
 * 
 * This script fixes 403 Forbidden errors for storage images
 * Use this ONLY on shared hosting where permissions need to be set
 * 
 * Usage: Visit this file in browser once: https://yourdomain.com/fix-storage-permissions.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('FIX_PERMISSIONS_PASSWORD', 'fix-storage-permissions-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== FIX_PERMISSIONS_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h2>Storage Permissions Fix Script</h2>";
echo "<p>Fixing storage permissions to resolve 403 Forbidden errors...</p>";

// Define directories to fix
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

// Fix permissions for directories
foreach ($directories as $dir) {
    if (file_exists($dir)) {
        if (chmod($dir, 0755)) {
            echo "✅ Fixed permissions for: $dir<br>";
        } else {
            echo "❌ Failed to fix permissions for: $dir<br>";
        }
    } else {
        echo "⚠️ Directory not found: $dir<br>";
    }
}

// Create .htaccess files if they don't exist
$htaccessFiles = [
    'storage/.htaccess' => 'storage/.htaccess',
    'storage/app/public/.htaccess' => 'storage/app/public/.htaccess',
    'public/storage/.htaccess' => 'public/storage/.htaccess'
];

foreach ($htaccessFiles as $file => $path) {
    if (!file_exists($path)) {
        echo "⚠️ .htaccess file not found: $path<br>";
        echo "Please upload the .htaccess files manually.<br>";
    } else {
        echo "✅ .htaccess file exists: $path<br>";
    }
}

// Test storage access
echo "<h3>Testing Storage Access</h3>";

// Test if storage directory is accessible
if (is_readable('storage/app/public')) {
    echo "✅ Storage directory is readable<br>";
} else {
    echo "❌ Storage directory is not readable<br>";
}

// Test if we can create files in storage
$testFile = 'storage/app/public/test-access.txt';
if (file_put_contents($testFile, 'test')) {
    echo "✅ Can write to storage directory<br>";
    unlink($testFile); // Clean up
} else {
    echo "❌ Cannot write to storage directory<br>";
}

// Check if storage link exists
if (file_exists('public/storage')) {
    if (is_link('public/storage')) {
        echo "✅ Storage link exists and is a symbolic link<br>";
        echo "Target: " . readlink('public/storage') . "<br>";
    } else {
        echo "⚠️ Storage link exists but is not a symbolic link<br>";
    }
} else {
    echo "❌ Storage link does not exist<br>";
    echo "You may need to create a symbolic link or use .htaccess redirect<br>";
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

echo "<li><strong>Create storage link:</strong><br>";
echo "Either create a symbolic link from public/storage to storage/app/public<br>";
echo "Or use the .htaccess redirect method<br><br>";
echo "</li>";

echo "<li><strong>Test access:</strong><br>";
echo "Test access to: https://yourdomain.com/storage/images/your-image.jpg<br>";
echo "Should return HTTP 200 OK instead of 403 Forbidden<br>";
echo "</li>";
echo "</ol>";

echo "<h3>Alternative Solutions</h3>";
echo "<ol>";
echo "<li><strong>Contact Hosting Support:</strong><br>";
echo "Ask them to enable symlink() function or fix storage permissions<br><br>";
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
    <title>Storage Permissions Fix</title>
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

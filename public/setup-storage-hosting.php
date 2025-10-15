<?php
/**
 * Setup Storage for Hosting Without Symlink Support
 * 
 * This script sets up storage access for hosting that doesn't support symlink
 * Use this on shared hosting where symlink() function is not available
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/setup-storage-hosting.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('SETUP_PASSWORD', 'setup-storage-hosting-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== SETUP_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h2>Setup Storage for Hosting Without Symlink Support</h2>";
echo "<p>Setting up storage access for hosting...</p>";

// Define paths
$target = $_SERVER['DOCUMENT_ROOT'] . '/../storage/app/public';
$link = $_SERVER['DOCUMENT_ROOT'] . '/storage';

echo "<h3>Path Information</h3>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Target Path:</strong> $target</p>";
echo "<p><strong>Link Path:</strong> $link</p>";

// Check if target exists
if (!file_exists($target)) {
    echo "<p style='color: red;'>❌ Target directory does not exist: $target</p>";
    echo "<p>Please check your Laravel installation.</p>";
    exit;
}

echo "<p style='color: green;'>✅ Target directory exists: $target</p>";

// Check if symlink function is available
if (!function_exists('symlink')) {
    echo "<p style='color: orange;'>⚠️ symlink() function is not available on this server.</p>";
    echo "<p>Using alternative method...</p>";
    
    // Create storage directory if it doesn't exist
    if (!file_exists($link)) {
        if (mkdir($link, 0755, true)) {
            echo "<p style='color: green;'>✅ Created storage directory: $link</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create storage directory.</p>";
            exit;
        }
    } else {
        echo "<p style='color: green;'>✅ Storage directory already exists: $link</p>";
    }
    
    // Create .htaccess file for redirect
    $htaccessContent = '# Storage Access Configuration
# This file allows access to storage images and prevents 403 Forbidden errors

# Enable rewrite engine
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /storage/
    
    # Allow access to all files in storage directory
    RewriteRule ^(.*)$ /../storage/app/public/$1 [L,QSA]
</IfModule>

# Security headers
<IfModule mod_headers.c>
    # Allow cross-origin requests for images
    Header always set Access-Control-Allow-Origin "*"
    Header always set Access-Control-Allow-Methods "GET, POST, OPTIONS"
    Header always set Access-Control-Allow-Headers "Content-Type"
</IfModule>

# File access permissions
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
</IfModule>';

    if (file_put_contents($link . '/.htaccess', $htaccessContent)) {
        echo "<p style='color: green;'>✅ Created .htaccess file for storage redirect</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create .htaccess file</p>";
    }
    
    // Test the setup
    echo "<h3>Testing Setup</h3>";
    
    // Test if storage directory is accessible
    if (is_readable($link)) {
        echo "<p style='color: green;'>✅ Storage directory is readable</p>";
    } else {
        echo "<p style='color: red;'>❌ Storage directory is not readable</p>";
    }
    
    // Test if we can create files in storage
    $testFile = $link . '/test-access.txt';
    if (file_put_contents($testFile, 'test')) {
        echo "<p style='color: green;'>✅ Can write to storage directory</p>";
        unlink($testFile); // Clean up
    } else {
        echo "<p style='color: red;'>❌ Cannot write to storage directory</p>";
    }
    
    echo "<h3>Setup Complete!</h3>";
    echo "<p style='color: green;'>✅ Storage setup completed successfully!</p>";
    echo "<p>Storage images should now be accessible at:</p>";
    echo "<ul>";
    echo "<li>https://odetune.shop/storage/images/your-image.jpg</li>";
    echo "<li>https://odetune.shop/storage/about-page/principal.jpg</li>";
    echo "<li>https://odetune.shop/storage/achievements/trophy.jpg</li>";
    echo "</ul>";
    
    echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
    
} else {
    echo "<p style='color: green;'>✅ symlink() function is available on this server.</p>";
    echo "<p>You can use the create-symlink.php script instead.</p>";
    echo "<p><a href='create-symlink.php?password=create-symlink-" . date('Y-m-d') . "'>Click here to create symlink</a></p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Setup Storage for Hosting</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        h2, h3 { color: #333; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
        ul { margin-left: 20px; }
        li { margin-bottom: 10px; }
    </style>
</head>
<body>
</body>
</html>

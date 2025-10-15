<?php
/**
 * Create Symlink for Laravel Storage
 * 
 * This script creates the necessary symbolic link for Laravel storage
 * Use this ONLY on shared hosting where symlink() function is available
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/create-symlink.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('SYMLINK_PASSWORD', 'create-symlink-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== SYMLINK_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h2>Create Symlink for Laravel Storage</h2>";
echo "<p>Creating symbolic link for storage access...</p>";

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

// Check if link already exists
if (file_exists($link)) {
    if (is_link($link)) {
        echo "<p style='color: orange;'>⚠️ Link already exists and is a symbolic link.</p>";
        echo "<p>Current target: " . readlink($link) . "</p>";
        
        // Check if it points to the correct location
        if (readlink($link) === $target) {
            echo "<p style='color: green;'>✅ Link points to correct location.</p>";
            echo "<p>No action needed.</p>";
        } else {
            echo "<p style='color: red;'>❌ Link points to wrong location.</p>";
            echo "<p>Removing old link...</p>";
            if (unlink($link)) {
                echo "<p style='color: green;'>✅ Old link removed.</p>";
            } else {
                echo "<p style='color: red;'>❌ Failed to remove old link.</p>";
                exit;
            }
        }
    } else {
        echo "<p style='color: red;'>❌ 'storage' exists but is not a symbolic link.</p>";
        echo "<p>Please manually rename or delete it first.</p>";
        exit;
    }
}

// Check if symlink function is available
if (!function_exists('symlink')) {
    echo "<p style='color: red;'>❌ symlink() function is not available on this server.</p>";
    echo "<p>Please contact your hosting provider to enable symlink() function.</p>";
    showAlternativeSolutions();
    exit;
}

// Try to create symbolic link
echo "<p>Creating symbolic link...</p>";
if (@symlink($target, $link)) {
    echo "<p style='color: green;'>✅ SUCCESS! Storage link created.</p>";
    echo "<p><strong>From:</strong> $link</p>";
    echo "<p><strong>To:</strong> $target</p>";
    
    // Test the link
    if (is_link($link) && readlink($link) === $target) {
        echo "<p style='color: green;'>✅ Link verified and working correctly.</p>";
    } else {
        echo "<p style='color: red;'>❌ Link created but verification failed.</p>";
    }
    
    echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
} else {
    echo "<p style='color: red;'>❌ Failed to create symbolic link.</p>";
    echo "<p>Error: " . error_get_last()['message'] ?? 'Unknown error' . "</p>";
    showAlternativeSolutions();
}

function showAlternativeSolutions() {
    echo "<h3>Alternative Solutions</h3>";
    echo "<ol>";
    echo "<li><strong>Contact Hosting Support:</strong><br>";
    echo "Ask them to enable symlink() function or create the link for you:<br>";
    echo "From: <code>/public_html/storage</code><br>";
    echo "To: <code>/public_html/storage/app/public</code><br><br>";
    echo "</li>";
    
    echo "<li><strong>Use .htaccess Redirect (Recommended):</strong><br>";
    echo "Create a folder at <code>public/storage</code> and add this .htaccess file:<br>";
    echo "<pre>";
    echo htmlspecialchars('
RewriteEngine On
RewriteBase /storage/
RewriteRule ^(.*)$ /../storage/app/public/$1 [L,QSA]
');
    echo "</pre><br>";
    echo "</li>";
    
    echo "<li><strong>Use ImageHelper Class (Already Implemented):</strong><br>";
    echo "We already have ImageHelper class that handles this automatically!<br>";
    echo "No additional action needed if you're using ImageHelper::getImageUrl()<br>";
    echo "</li>";
    
    echo "<li><strong>Copy Files Method (Not Recommended):</strong><br>";
    echo "You can copy files from <code>storage/app/public</code> to <code>public/storage</code><br>";
    echo "⚠️ Note: You'll need to copy files every time you upload new images<br>";
    echo "</li>";
    echo "</ol>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Symlink</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        h2, h3 { color: #333; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
        ol, ul { margin-left: 20px; }
        li { margin-bottom: 20px; }
    </style>
</head>
<body>
</body>
</html>

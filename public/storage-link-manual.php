<?php
/**
 * Manual Storage Link Creator for Shared Hosting
 * 
 * This file creates a symbolic link manually when symlink() function is disabled
 * Use this ONLY on shared hosting where symlink() is not available
 * 
 * Usage: Visit this file in browser once: https://yourdomain.com/storage-link-manual.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('MANUAL_LINK_PASSWORD', 'your-secure-password-here-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== MANUAL_LINK_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

// Define paths
$target = $_SERVER['DOCUMENT_ROOT'] . '/../storage/app/public';
$link = $_SERVER['DOCUMENT_ROOT'] . '/storage';

// Check if link already exists
if (file_exists($link)) {
    if (is_link($link)) {
        echo "✅ Storage link already exists and is a symbolic link.<br>";
        echo "Target: " . readlink($link) . "<br>";
    } else {
        echo "⚠️ 'storage' folder exists but is not a symbolic link.<br>";
        echo "Please manually rename or delete it first.<br>";
    }
    exit;
}

// Check if target exists
if (!file_exists($target)) {
    echo "❌ Target directory does not exist: $target<br>";
    echo "Please check your Laravel installation.<br>";
    exit;
}

// Try to create symbolic link
if (function_exists('symlink')) {
    if (@symlink($target, $link)) {
        echo "✅ SUCCESS! Storage link created using symlink().<br>";
        echo "From: $link<br>";
        echo "To: $target<br>";
        echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
    } else {
        echo "❌ Failed to create symbolic link with symlink().<br>";
        echo "Error: " . error_get_last()['message'] ?? 'Unknown error' . "<br>";
        showManualInstructions($target, $link);
    }
} else {
    echo "❌ symlink() function is not available on this server.<br>";
    showManualInstructions($target, $link);
}

function showManualInstructions($target, $link) {
    echo "<br><h3>Manual Solution Options:</h3>";
    echo "<ol>";
    echo "<li><strong>Contact Hosting Support:</strong><br>";
    echo "Ask them to enable symlink() function or create the link for you:<br>";
    echo "From: <code>$link</code><br>";
    echo "To: <code>$target</code><br><br>";
    echo "</li>";
    
    echo "<li><strong>Use .htaccess Redirect (Alternative):</strong><br>";
    echo "Create a folder at <code>public/storage</code> and add this .htaccess file:<br>";
    echo "<pre>";
    echo htmlspecialchars('
RewriteEngine On
RewriteBase /storage/
RewriteRule ^(.*)$ /../storage/app/public/$1 [L]
');
    echo "</pre><br>";
    echo "</li>";
    
    echo "<li><strong>Copy Files Instead (Not Recommended):</strong><br>";
    echo "You can copy files from <code>storage/app/public</code> to <code>public/storage</code><br>";
    echo "⚠️ Note: You'll need to copy files every time you upload new images<br><br>";
    echo "</li>";
    
    echo "<li><strong>Use Helper Class (Recommended):</strong><br>";
    echo "We already have ImageHelper class that handles this automatically!<br>";
    echo "No additional action needed if you're using ImageHelper::getImageUrl()<br>";
    echo "</li>";
    echo "</ol>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Storage Link Setup</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
        h3 { color: #333; margin-top: 30px; }
        li { margin-bottom: 20px; }
    </style>
</head>
<body>
</body>
</html>

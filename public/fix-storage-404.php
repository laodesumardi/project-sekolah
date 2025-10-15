<?php
/**
 * Fix Storage 404 Error
 * 
 * This script fixes 404 errors for storage images
 * Use this to fix "This Page Does Not Exist" errors for storage URLs
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/fix-storage-404.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('FIX_STORAGE_404_PASSWORD', 'fix-storage-404-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== FIX_STORAGE_404_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h2>Fix Storage 404 Error</h2>";
echo "<p>Fixing 404 errors for storage images...</p>";

// Check current directory
$currentDir = getcwd();
echo "<h3>Current Directory</h3>";
echo "<p><strong>Current Directory:</strong> $currentDir</p>";

// Check Laravel project structure
echo "<h3>Laravel Project Structure Check</h3>";

$requiredFiles = [
    'artisan',
    'composer.json',
    'app/Http/Controllers',
    'routes/web.php',
    'public/index.php',
    'storage/app/public'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ Found: $file</p>";
    } else {
        echo "<p style='color: red;'>❌ Missing: $file</p>";
    }
}

// Check storage directory structure
echo "<h3>Storage Directory Structure</h3>";

$storageDirs = [
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/app/public/images',
    'storage/app/public/about-page',
    'storage/app/public/achievements'
];

foreach ($storageDirs as $dir) {
    if (file_exists($dir)) {
        echo "<p style='color: green;'>✅ Found: $dir</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Missing: $dir</p>";
        
        // Create missing directories
        if (strpos($dir, 'storage') === 0) {
            if (mkdir($dir, 0755, true)) {
                echo "<p style='color: green;'>✅ Created: $dir</p>";
            } else {
                echo "<p style='color: red;'>❌ Failed to create: $dir</p>";
            }
        }
    }
}

// Check if storage link exists
echo "<h3>Storage Link Check</h3>";

if (file_exists('public/storage')) {
    if (is_link('public/storage')) {
        echo "<p style='color: green;'>✅ Storage link exists and is a symbolic link</p>";
        echo "<p><strong>Link target:</strong> " . readlink('public/storage') . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Storage link exists but is not a symbolic link</p>";
        echo "<p>Removing existing storage directory...</p>";
        if (rmdir('public/storage')) {
            echo "<p style='color: green;'>✅ Removed existing storage directory</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to remove existing storage directory</p>";
        }
    }
} else {
    echo "<p style='color: orange;'>⚠️ Storage link does not exist</p>";
}

// Create storage link
echo "<h3>Creating Storage Link</h3>";

if (!file_exists('public/storage')) {
    if (function_exists('symlink')) {
        if (symlink('../storage/app/public', 'public/storage')) {
            echo "<p style='color: green;'>✅ Storage link created successfully</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create storage link</p>";
            echo "<p>Creating storage directory instead...</p>";
            
            // Create storage directory and copy files
            if (mkdir('public/storage', 0755, true)) {
                echo "<p style='color: green;'>✅ Created storage directory</p>";
                
                // Copy files from storage/app/public to public/storage
                if (file_exists('storage/app/public')) {
                    $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator('storage/app/public'),
                        RecursiveIteratorIterator::LEAVES_ONLY
                    );
                    
                    $copiedFiles = 0;
                    foreach ($files as $file) {
                        if ($file->isFile()) {
                            $relativePath = substr($file->getPathname(), strlen('storage/app/public/'));
                            $targetPath = 'public/storage/' . $relativePath;
                            $targetDir = dirname($targetPath);
                            
                            if (!file_exists($targetDir)) {
                                mkdir($targetDir, 0755, true);
                            }
                            
                            if (copy($file->getPathname(), $targetPath)) {
                                $copiedFiles++;
                            }
                        }
                    }
                    
                    echo "<p style='color: green;'>✅ Copied $copiedFiles files to public/storage</p>";
                }
            } else {
                echo "<p style='color: red;'>❌ Failed to create storage directory</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>❌ symlink() function is not available</p>";
        echo "<p>Creating storage directory instead...</p>";
        
        // Create storage directory and copy files
        if (mkdir('public/storage', 0755, true)) {
            echo "<p style='color: green;'>✅ Created storage directory</p>";
            
            // Copy files from storage/app/public to public/storage
            if (file_exists('storage/app/public')) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator('storage/app/public'),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );
                
                $copiedFiles = 0;
                foreach ($files as $file) {
                    if ($file->isFile()) {
                        $relativePath = substr($file->getPathname(), strlen('storage/app/public/'));
                        $targetPath = 'public/storage/' . $relativePath;
                        $targetDir = dirname($targetPath);
                        
                        if (!file_exists($targetDir)) {
                            mkdir($targetDir, 0755, true);
                        }
                        
                        if (copy($file->getPathname(), $targetPath)) {
                            $copiedFiles++;
                        }
                    }
                }
                
                echo "<p style='color: green;'>✅ Copied $copiedFiles files to public/storage</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Failed to create storage directory</p>";
        }
    }
} else {
    echo "<p style='color: green;'>✅ Storage link already exists</p>";
}

// Create .htaccess files
echo "<h3>Creating .htaccess Files</h3>";

// Create .htaccess for public/storage
$htaccessContent = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ /storage/app/public/$1 [L,QSA]
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
Options -Indexes>';

if (file_put_contents('public/storage/.htaccess', $htaccessContent)) {
    echo "<p style='color: green;'>✅ Created .htaccess for public/storage</p>";
} else {
    echo "<p style='color: red;'>❌ Failed to create .htaccess for public/storage</p>";
}

// Create .htaccess for storage root
$storageHtaccessContent = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ app/public/$1 [L,QSA]
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
Options -Indexes>';

if (file_put_contents('storage/.htaccess', $storageHtaccessContent)) {
    echo "<p style='color: green;'>✅ Created .htaccess for storage root</p>";
} else {
    echo "<p style='color: red;'>❌ Failed to create .htaccess for storage root</p>";
}

// Create .htaccess for storage/app/public
$appPublicHtaccessContent = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^(.*)$ - [L]
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
Options -Indexes>';

if (file_put_contents('storage/app/public/.htaccess', $appPublicHtaccessContent)) {
    echo "<p style='color: green;'>✅ Created .htaccess for storage/app/public</p>";
} else {
    echo "<p style='color: red;'>❌ Failed to create .htaccess for storage/app/public</p>";
}

// Fix permissions
echo "<h3>Fixing Permissions</h3>";

$directories = [
    'storage',
    'storage/app',
    'storage/app/public',
    'public/storage'
];

foreach ($directories as $dir) {
    if (file_exists($dir)) {
        if (chmod($dir, 0755)) {
            echo "<p style='color: green;'>✅ Fixed permissions for: $dir</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to fix permissions for: $dir</p>";
        }
    }
}

// Test storage access
echo "<h3>Testing Storage Access</h3>";

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

// Create test images if they don't exist
echo "<h3>Creating Test Images</h3>";

$testImages = [
    'storage/app/public/images/placeholder-image.jpg',
    'storage/app/public/about-page/principal.jpg',
    'storage/app/public/achievements/trophy.jpg'
];

foreach ($testImages as $image) {
    $dir = dirname($image);
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
    
    if (!file_exists($image)) {
        // Create a simple test image (1x1 pixel)
        $imageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
        if (file_put_contents($image, $imageData)) {
            echo "<p style='color: green;'>✅ Created test image: $image</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create test image: $image</p>";
        }
    } else {
        echo "<p style='color: green;'>✅ Test image already exists: $image</p>";
    }
}

// Provide solutions
echo "<h3>Solutions</h3>";
echo "<ol>";
echo "<li><strong>Check storage link:</strong><br>";
echo "Make sure public/storage is linked to storage/app/public<br>";
echo "Run: <code>ls -la public/storage</code><br><br>";
echo "</li>";

echo "<li><strong>Check file permissions:</strong><br>";
echo "Make sure storage directories are readable<br>";
echo "Run: <code>chmod -R 755 storage/</code><br>";
echo "Run: <code>chmod -R 755 public/storage/</code><br><br>";
echo "</li>";

echo "<li><strong>Check .htaccess files:</strong><br>";
echo "Make sure .htaccess files exist in storage directories<br>";
echo "Check if rewrite rules are correct<br><br>";
echo "</li>";

echo "<li><strong>Test storage access:</strong><br>";
echo "Test these URLs:<br>";
echo "- <code>https://odetune.shop/storage/images/placeholder-image.jpg</code><br>";
echo "- <code>https://odetune.shop/storage/about-page/principal.jpg</code><br>";
echo "- <code>https://odetune.shop/storage/achievements/trophy.jpg</code><br><br>";
echo "</li>";

echo "<li><strong>Use ImageHelper class:</strong><br>";
echo "Use ImageHelper::getImageUrl() which handles fallback automatically<br>";
echo "No additional configuration needed<br><br>";
echo "</li>";
echo "</ol>";

echo "<h3>Quick Fix Commands</h3>";
echo "<p>Run these commands in terminal to fix storage issues:</p>";
echo "<pre style='background: #f4f4f4; padding: 15px; border-radius: 5px;'>";
echo "# Create storage link\n";
echo "ln -s ../storage/app/public public/storage\n";
echo "\n";
echo "# Fix permissions\n";
echo "chmod -R 755 storage/\n";
echo "chmod -R 755 public/storage/\n";
echo "\n";
echo "# Test access\n";
echo "curl -I https://odetune.shop/storage/images/placeholder-image.jpg\n";
echo "</pre>";

echo "<br><strong>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix Storage 404 Error</title>
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

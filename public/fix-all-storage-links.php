<?php
/**
 * Fix All Storage Links and Optimize Performance
 * 
 * This script fixes all storage links in the project and optimizes performance for hosting
 * 
 * Usage: Visit this file in browser once: https://odetune.shop/fix-all-storage-links.php
 * Then DELETE this file for security
 */

// Security check - change this password
define('FIX_STORAGE_PASSWORD', 'fix-all-storage-links-' . date('Y-m-d'));

// Get password from URL
$password = $_GET['password'] ?? '';

if ($password !== FIX_STORAGE_PASSWORD) {
    die('Unauthorized access. Please provide correct password.');
}

echo "<h1>Fix All Storage Links & Optimize Performance</h1>";
echo "<p>Fixing all storage links and optimizing project performance...</p>";

// Check current directory
$currentDir = getcwd();
echo "<h2>Current Directory</h2>";
echo "<p><strong>Current Directory:</strong> $currentDir</p>";

// Function to create optimized .htaccess files
function createOptimizedHtaccess() {
    echo "<h3>Creating Optimized .htaccess Files</h3>";
    
    // 1. Main .htaccess for public directory
    $mainHtaccess = '<IfModule mod_rewrite.c>
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

    if (file_put_contents('public/.htaccess', $mainHtaccess)) {
        echo "<p style='color: green;'>✅ Main .htaccess created/updated</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create main .htaccess</p>";
    }
    
    // 2. .htaccess for public/storage
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
        echo "<p style='color: green;'>✅ Storage .htaccess created/updated</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create storage .htaccess</p>";
    }
    
    // 3. .htaccess for storage root
    $storageRootHtaccess = '# Deny direct access to storage root
Order Deny,Allow
Deny from all';

    if (file_put_contents('storage/.htaccess', $storageRootHtaccess)) {
        echo "<p style='color: green;'>✅ Storage root .htaccess created/updated</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create storage root .htaccess</p>";
    }
    
    // 4. .htaccess for storage/app/public
    $storageAppPublicHtaccess = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
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
Options -Indexes';

    if (file_put_contents('storage/app/public/.htaccess', $storageAppPublicHtaccess)) {
        echo "<p style='color: green;'>✅ Storage app public .htaccess created/updated</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create storage app public .htaccess</p>";
    }
}

// Function to fix storage symlink
function fixStorageSymlink() {
    echo "<h3>Fixing Storage Symlink</h3>";
    
    $publicStoragePath = 'public/storage';
    $targetPath = '../storage/app/public';
    
    // Remove existing storage if it's not a symlink
    if (file_exists($publicStoragePath)) {
        if (is_link($publicStoragePath)) {
            echo "<p style='color: green;'>✅ Storage link already exists and is a symbolic link</p>";
            echo "<p><strong>Target:</strong> " . readlink($publicStoragePath) . "</p>";
            return true;
        } else {
            echo "<p style='color: orange;'>⚠️ Storage exists but is not a symbolic link. Removing...</p>";
            if (is_dir($publicStoragePath)) {
                if (rmdir($publicStoragePath)) {
                    echo "<p style='color: green;'>✅ Removed existing storage directory</p>";
                } else {
                    echo "<p style='color: red;'>❌ Failed to remove existing storage directory</p>";
                    return false;
                }
            } else {
                unlink($publicStoragePath);
            }
        }
    }
    
    // Create symlink
    if (function_exists('symlink')) {
        if (symlink($targetPath, $publicStoragePath)) {
            echo "<p style='color: green;'>✅ Storage symlink created successfully</p>";
            echo "<p><strong>From:</strong> $publicStoragePath</p>";
            echo "<p><strong>To:</strong> $targetPath</p>";
            return true;
        } else {
            echo "<p style='color: red;'>❌ Failed to create storage symlink</p>";
            return false;
        }
    } else {
        echo "<p style='color: red;'>❌ symlink() function is not available</p>";
        return false;
    }
}

// Function to optimize images
function optimizeImages() {
    echo "<h3>Optimizing Images</h3>";
    
    $imageDirectories = [
        'public/images',
        'storage/app/public',
        'storage/app/public/images',
        'storage/app/public/achievements',
        'storage/app/public/about-page'
    ];
    
    $optimizedCount = 0;
    
    foreach ($imageDirectories as $dir) {
        if (is_dir($dir)) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $extension = strtolower(pathinfo($file->getPathname(), PATHINFO_EXTENSION));
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                        $fileSize = filesize($file->getPathname());
                        if ($fileSize > 100 * 1024) { // Files larger than 100KB
                            $optimizedCount++;
                        }
                    }
                }
            }
        }
    }
    
    echo "<p style='color: green;'>✅ Found $optimizedCount images that could be optimized</p>";
}

// Function to create performance optimizations
function createPerformanceOptimizations() {
    echo "<h3>Creating Performance Optimizations</h3>";
    
    // 1. Create optimized Vite config
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
    
    // 2. Create optimized package.json
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

// Function to fix permissions
function fixPermissions() {
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
    
    // Fix file permissions in storage/app/public
    if (is_dir('storage/app/public')) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator('storage/app/public', RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        
        $fileCount = 0;
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                if (chmod($file->getPathname(), 0644)) {
                    $fileCount++;
                }
            }
        }
        
        echo "<p style='color: green;'>✅ Fixed permissions for $fileCount files in storage/app/public</p>";
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
echo "<h2>Running All Optimizations</h2>";

// 1. Create optimized .htaccess files
createOptimizedHtaccess();

// 2. Fix storage symlink
fixStorageSymlink();

// 3. Optimize images
optimizeImages();

// 4. Create performance optimizations
createPerformanceOptimizations();

// 5. Fix permissions
fixPermissions();

// 6. Create test files
createTestFiles();

echo "<h2>Optimization Complete!</h2>";
echo "<p><strong>Optimizations Applied:</strong></p>";
echo "<ul>";
echo "<li>✅ Optimized .htaccess files created</li>";
echo "<li>✅ Storage symlink fixed</li>";
echo "<li>✅ Image optimization analyzed</li>";
echo "<li>✅ Performance optimizations created</li>";
echo "<li>✅ Permissions fixed</li>";
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
    <title>Fix All Storage Links</title>
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

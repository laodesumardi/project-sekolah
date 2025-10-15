# Fix 403 Forbidden Error - PuTTY Commands Guide

## 🚨 Problem
Error 403 Forbidden saat mengakses storage images di hosting

## 🔧 Commands untuk PuTTY/SSH

### **1. Check Storage Directory**
```bash
# Check if storage directory exists
ls -la public/storage

# If not exists, check what's in public directory
ls -la public/

# Check if storage exists in root
ls -la storage/
```

### **2. Create Storage Directory (if not exists)**
```bash
# Create storage directory in public
mkdir -p public/storage

# Set proper permissions
chmod 755 public/storage
```

### **3. Create Symlink (if supported)**
```bash
# Create symbolic link from public/storage to storage/app/public
ln -s ../storage/app/public public/storage

# Check if symlink was created
ls -la public/storage
# Should show: storage -> ../storage/app/public
```

### **4. Fix Permissions**
```bash
# Fix permissions for storage directories
chmod 755 storage/
chmod 755 storage/app/
chmod 755 storage/app/public/

# Fix permissions for files in storage
find storage/app/public/ -type f -exec chmod 644 {} \;
find storage/app/public/ -type d -exec chmod 755 {} \;
```

### **5. Create .htaccess Files**

#### **A. Create .htaccess for public/storage**
```bash
cat > public/storage/.htaccess << 'EOF'
# Storage Access Configuration
<IfModule mod_rewrite.c>
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
Options -Indexes
EOF
```

#### **B. Create .htaccess for storage root**
```bash
cat > storage/.htaccess << 'EOF'
# Storage Root Access Configuration
<IfModule mod_rewrite.c>
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
Options -Indexes
EOF
```

#### **C. Create .htaccess for storage/app/public**
```bash
cat > storage/app/public/.htaccess << 'EOF'
# Storage Public Access Configuration
<IfModule mod_rewrite.c>
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
Options -Indexes
EOF
```

### **6. Test Storage Access**
```bash
# Test if storage directory is accessible
ls -la public/storage/

# Test if files exist
ls -la storage/app/public/

# Test specific files
ls -la storage/app/public/images/
ls -la storage/app/public/about-page/
```

### **7. Alternative: Copy Files Method**
```bash
# If symlink doesn't work, copy files instead
cp -r storage/app/public/* public/storage/

# Set permissions for copied files
chmod -R 755 public/storage/
find public/storage/ -type f -exec chmod 644 {} \;
```

## 🔍 Troubleshooting Commands

### **1. Check Current Directory**
```bash
# Check where you are
pwd

# List current directory contents
ls -la

# Check if Laravel project structure exists
ls -la app/
ls -la storage/
ls -la public/
```

### **2. Check File Permissions**
```bash
# Check permissions for storage
ls -la storage/
ls -la storage/app/
ls -la storage/app/public/

# Check permissions for public
ls -la public/
```

### **3. Check if Symlink Function is Available**
```bash
# Test if symlink function works
ln -s test test-link
if [ $? -eq 0 ]; then
    echo "Symlink function is available"
    rm test-link
else
    echo "Symlink function is not available"
fi
```

### **4. Check Apache/Nginx Configuration**
```bash
# Check if .htaccess files are being read
# Look for any error messages in logs
tail -f /var/log/apache2/error.log
# or
tail -f /var/log/nginx/error.log
```

## 📋 Step-by-Step Solution

### **Step 1: Check Current Status**
```bash
# Check current directory
pwd

# Check if storage exists
ls -la storage/

# Check if public/storage exists
ls -la public/storage
```

### **Step 2: Create Storage Link**
```bash
# Option A: Create symlink (if supported)
ln -s ../storage/app/public public/storage

# Option B: Copy files (if symlink not supported)
mkdir -p public/storage
cp -r storage/app/public/* public/storage/
```

### **Step 3: Set Permissions**
```bash
# Set permissions for storage
chmod 755 storage/
chmod 755 storage/app/
chmod 755 storage/app/public/

# Set permissions for public/storage
chmod 755 public/storage/
find public/storage/ -type f -exec chmod 644 {} \;
```

### **Step 4: Create .htaccess Files**
```bash
# Create .htaccess files using the commands above
# (Copy and paste the cat commands from above)
```

### **Step 5: Test Access**
```bash
# Test if storage is accessible
curl -I https://yourdomain.com/storage/images/placeholder-image.jpg

# Should return: HTTP 200 OK
```

## 🎯 Expected Results

### **Before Fix:**
```
❌ https://yourdomain.com/storage/images/your-image.jpg
HTTP 403 Forbidden
```

### **After Fix:**
```
✅ https://yourdomain.com/storage/images/your-image.jpg
HTTP 200 OK
Content-Type: image/jpeg
```

## ⚠️ Important Notes

1. **Make sure you're in the correct directory** (Laravel project root)
2. **Check if storage directory exists** before creating symlink
3. **Set proper permissions** for all directories and files
4. **Test access** after making changes
5. **Delete setup files** after fixing the issue

## 🚀 Quick Fix Commands

```bash
# Quick fix for 403 error
mkdir -p public/storage
ln -s ../storage/app/public public/storage
chmod 755 storage/
chmod 755 storage/app/
chmod 755 storage/app/public/
chmod 755 public/storage/
find storage/app/public/ -type f -exec chmod 644 {} \;
find public/storage/ -type f -exec chmod 644 {} \;
```

**Run these commands in order and test access!** 🎉

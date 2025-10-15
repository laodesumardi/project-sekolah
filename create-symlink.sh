#!/bin/bash

# Create Symlink for Laravel Storage
# This script creates the necessary symbolic link for Laravel storage
# Use this on servers where symlink() function is available

echo "Creating symlink for Laravel storage..."

# Define paths
TARGET="storage/app/public"
LINK="public/storage"

# Check if target exists
if [ ! -d "$TARGET" ]; then
    echo "❌ Target directory does not exist: $TARGET"
    echo "Please check your Laravel installation."
    exit 1
fi

echo "✅ Target directory exists: $TARGET"

# Check if link already exists
if [ -e "$LINK" ]; then
    if [ -L "$LINK" ]; then
        echo "⚠️ Link already exists and is a symbolic link."
        echo "Current target: $(readlink $LINK)"
        
        # Check if it points to the correct location
        if [ "$(readlink $LINK)" = "$TARGET" ]; then
            echo "✅ Link points to correct location."
            echo "No action needed."
            exit 0
        else
            echo "❌ Link points to wrong location."
            echo "Removing old link..."
            rm "$LINK"
            if [ $? -eq 0 ]; then
                echo "✅ Old link removed."
            else
                echo "❌ Failed to remove old link."
                exit 1
            fi
        fi
    else
        echo "❌ '$LINK' exists but is not a symbolic link."
        echo "Please manually rename or delete it first."
        exit 1
    fi
fi

# Create symbolic link
echo "Creating symbolic link..."
ln -s "../$TARGET" "$LINK"

if [ $? -eq 0 ]; then
    echo "✅ SUCCESS! Storage link created."
    echo "From: $LINK"
    echo "To: $TARGET"
    
    # Test the link
    if [ -L "$LINK" ] && [ "$(readlink $LINK)" = "$TARGET" ]; then
        echo "✅ Link verified and working correctly."
    else
        echo "❌ Link created but verification failed."
        exit 1
    fi
else
    echo "❌ Failed to create symbolic link."
    exit 1
fi

echo "🎉 Symlink created successfully!"
echo "Storage images should now be accessible at: https://yourdomain.com/storage/images/your-image.jpg"

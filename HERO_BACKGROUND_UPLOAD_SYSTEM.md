# Hero Background Upload System

## Overview
Sistem upload gambar background hero yang memungkinkan admin untuk mengupload, preview, dan menghapus gambar background hero dengan opacity rendah.

## Features
- ✅ Upload gambar background hero dari admin panel
- ✅ Preview gambar yang akan diupload
- ✅ Hapus gambar background dengan mudah
- ✅ Background dinamis dengan opacity rendah
- ✅ Responsive design
- ✅ Animasi fade in

## Files Modified

### 1. `resources/views/welcome.blade.php`
- Modified hero section to use dynamic background image from admin panel
- Added fallback to placeholder image if no image uploaded

### 2. `resources/views/layouts/app.blade.php`
- Added CSS for hero background with opacity overlay
- Responsive background for mobile devices
- Fade in animation

### 3. `resources/views/admin/homepage-settings/edit.blade.php`
- Enhanced upload interface with drag & drop
- Preview functionality for uploaded images
- Delete functionality with confirmation
- Visual feedback for user actions

### 4. `app/Http/Controllers/Admin/HomepageSettingController.php`
- Handles file upload and deletion
- Validates image files (JPG, PNG, GIF, max 2MB)
- Manages storage and file paths

## CSS Classes

### Hero Background
```css
.hero-background {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.hero-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}
```

### Overlay
```css
.hero-background-overlay {
    background: rgba(0, 0, 0, 0.1);
}
```

## Usage

### Admin Panel
1. Navigate to `http://127.0.0.1:8000/admin/homepage-settings/edit`
2. Scroll to "Hero Section"
3. Find "Gambar Background Hero" section
4. Upload image by clicking upload area or drag & drop
5. Preview the image
6. Click "Simpan Perubahan" to save

### Frontend
- Background image automatically loads from admin panel
- Fallback to placeholder if no image uploaded
- Opacity overlay for better text readability

## File Structure
```
public/
├── images/
│   ├── placeholders/
│   │   └── placeholder-hero-background.jpg
│   └── backgrounds/
│       └── school-yard.jpg (optional)
└── css/
    └── hero-background.css
```

## Testing
- **Admin Panel**: `http://127.0.0.1:8000/admin/homepage-settings/edit`
- **Frontend**: `http://127.0.0.1:8000/`
- **Test Page**: `http://127.0.0.1:8000/test-hero-background-upload-system.html`

## Technical Details

### Image Requirements
- Format: JPG, PNG, GIF
- Max size: 2MB
- Recommended: 1920x1080 or higher
- Orientation: Landscape preferred

### Storage
- Images stored in `storage/app/public/homepage/`
- Public access via symlink `public/storage`
- Automatic cleanup when image deleted

### Responsive Design
- Desktop: Fixed background attachment
- Mobile: Scroll background attachment
- Optimized for all screen sizes

## Benefits
1. **Admin Control**: Easy image management from admin panel
2. **User Experience**: Beautiful background with proper opacity
3. **Performance**: Optimized image loading and caching
4. **Flexibility**: Easy to change background without code changes
5. **Responsive**: Works on all devices

## Future Enhancements
- Multiple background options
- Background slideshow
- Video background support
- Advanced image editing tools
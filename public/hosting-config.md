# Konfigurasi Hosting untuk Gambar

## 1. Struktur File yang Benar

Pastikan struktur file di hosting seperti ini:

```
public_html/
├── index.php
├── logo.png
├── favicon.ico
├── images/
│   ├── placeholder-image.jpg
│   ├── placeholder-news.jpg
│   ├── placeholder-facility.jpg
│   ├── placeholder-gallery.jpg
│   ├── logos/
│   │   ├── logo.png
│   │   └── logo.svg
│   ├── facilities/
│   │   ├── classroom.jpg
│   │   ├── library.jpg
│   │   └── ...
│   └── ...
├── storage/
│   └── app/
│       └── public/
│           ├── registrations/
│           ├── news/
│           └── ...
└── .htaccess
```

## 2. Permission File

Set permission yang benar:
```bash
chmod 755 public/
chmod 755 public/images/
chmod 644 public/logo.png
chmod 644 public/favicon.ico
chmod 644 public/images/*.jpg
chmod 644 public/images/*.png
```

## 3. URL Gambar yang Benar

- Logo: `https://yourdomain.com/logo.png`
- Favicon: `https://yourdomain.com/favicon.ico`
- Placeholder: `https://yourdomain.com/images/placeholder-image.jpg`

## 4. Troubleshooting

### Jika gambar tidak muncul:

1. **Cek URL**: Pastikan URL gambar benar
2. **Cek Permission**: Pastikan file bisa diakses
3. **Cek Path**: Pastikan path file benar
4. **Cek .htaccess**: Pastikan .htaccess tidak memblokir gambar
5. **Cek Browser**: Clear cache browser

### Test URL Gambar:

```html
<!-- Test di browser -->
<img src="https://yourdomain.com/logo.png" alt="Test Logo">
<img src="https://yourdomain.com/images/placeholder-image.jpg" alt="Test Placeholder">
```

## 5. Fallback Images

Jika gambar utama tidak ada, sistem akan menggunakan:
1. `images/placeholder-image.jpg`
2. `images/placeholder-news.jpg`
3. `images/placeholder-facility.jpg`
4. `images/placeholder-gallery.jpg`

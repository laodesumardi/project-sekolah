# Halaman Perpustakaan SMP Negeri 01 Namrole

## Deskripsi
Halaman perpustakaan yang menampilkan struktur organisasi perpustakaan berdasarkan gambar yang diberikan. Halaman ini mencakup informasi lengkap tentang tim perpustakaan, layanan yang disediakan, dan koleksi yang tersedia.

## Fitur Utama

### 1. Struktur Organisasi
- **Pimpinan & Komite**: Kepala Sekolah dan Komite Sekolah
- **Manajemen Perpustakaan**: Kepala Perpustakaan dan Dewan Guru
- **Layanan Perpustakaan**: Layanan Teknis, Layanan Pemustaka, dan Koordinator Literasi
- **Duta Literasi**: Duta Literasi Siswa, Tenaga Kependidikan, dan Guru

### 2. Informasi Layanan
- Layanan Sirkulasi
- Layanan Referensi
- Layanan Teknis
- Program Literasi

### 3. Koleksi Perpustakaan
- Buku Teks
- Buku Fiksi
- Buku Non-Fiksi
- Majalah & Koran
- Koleksi Digital

### 4. Informasi Kontak
- Jam Operasional
- Lokasi
- Kontak

## File yang Dibuat
1. `app/Http/Controllers/LibraryController.php` - Controller untuk halaman perpustakaan
2. `resources/views/frontend/library/index.blade.php` - View halaman perpustakaan
3. Route ditambahkan di `routes/web.php`
4. Menu ditambahkan di `resources/views/components/navbar.blade.php`

## URL
- Halaman Perpustakaan: `http://127.0.0.1:8000/perpustakaan`
- Route Name: `library`

## Struktur Data
Controller menyediakan data struktur organisasi dengan informasi:
- Nama lengkap dan gelar
- Posisi/jabatan
- Deskripsi tanggung jawab
- Path foto (placeholder)

## Responsive Design
Halaman menggunakan Tailwind CSS dengan desain responsif untuk:
- Desktop (grid layout)
- Tablet (grid layout dengan breakpoint)
- Mobile (stack layout)

## Icon dan Styling
- Menggunakan Font Awesome icons
- Color coding untuk setiap level organisasi
- Hover effects dan transitions
- Card-based layout dengan shadows

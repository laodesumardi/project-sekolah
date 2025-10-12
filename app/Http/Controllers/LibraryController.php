<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display the library page with organizational structure.
     */
    public function index()
    {
        // Library organizational structure data
        $libraryStructure = [
            'leadership' => [
                'kepala_sekolah' => [
                    'name' => 'Muhammad Said Buton, SH, Gr',
                    'position' => 'Kepala Sekolah',
                    'photo' => 'images/kepala-sekolah.jpg',
                    'description' => 'Bertanggung jawab atas pengawasan dan kebijakan perpustakaan secara keseluruhan.'
                ],
                'komite' => [
                    'name' => 'Abas Siolont',
                    'position' => 'Komite Sekolah',
                    'photo' => 'images/komite.jpg',
                    'description' => 'Memberikan dukungan dan masukan untuk pengembangan perpustakaan.'
                ]
            ],
            'management' => [
                'kepala_perpustakaan' => [
                    'name' => 'Rusmin T., S.Pd, Gr',
                    'position' => 'Kepala Perpustakaan',
                    'photo' => 'images/kepala-perpustakaan.jpg',
                    'description' => 'Mengelola operasional perpustakaan dan mengkoordinasikan semua layanan.'
                ],
                'dewan_guru' => [
                    'name' => 'Dewan Guru',
                    'position' => 'Dewan Guru',
                    'photo' => 'images/dewan-guru.jpg',
                    'description' => 'Mendukung program literasi dan pembelajaran berbasis perpustakaan.'
                ]
            ],
            'services' => [
                'layanan_teknis' => [
                    'name' => 'Sahelna Batmomolin, S.Pd',
                    'position' => 'Layanan Teknis',
                    'photo' => 'images/layanan-teknis.jpg',
                    'description' => 'Mengelola katalogisasi, klasifikasi, dan pengolahan koleksi perpustakaan.'
                ],
                'layanan_pemustaka' => [
                    'name' => 'Amelia Takimpo, S.Pd, Gr',
                    'position' => 'Layanan Pemustaka',
                    'photo' => 'images/layanan-pemustaka.jpg',
                    'description' => 'Melayani pemustaka, sirkulasi, dan referensi perpustakaan.'
                ],
                'koordinator_literasi' => [
                    'name' => 'Rubiati Wabula, SS, Gr',
                    'position' => 'Koordinator Tim Literasi',
                    'photo' => 'images/koordinator-literasi.jpg',
                    'description' => 'Mengkoordinasikan program literasi dan kegiatan membaca di sekolah.'
                ]
            ],
            'ambassadors' => [
                'duta_siswa' => [
                    'name' => 'Villia Aininda Putri Purnama',
                    'position' => 'Duta Literasi Siswa',
                    'photo' => 'images/duta-siswa.jpg',
                    'description' => 'Mewakili siswa dalam program literasi dan menjadi contoh bagi teman-temannya.'
                ],
                'duta_tendik' => [
                    'name' => 'Suci Asyurah Khas, S.Pd',
                    'position' => 'Duta Literasi Tenaga Kependidikan',
                    'photo' => 'images/duta-tendik.jpg',
                    'description' => 'Menggerakkan literasi di kalangan tenaga kependidikan dan staf sekolah.'
                ],
                'duta_guru' => [
                    'name' => 'Nyaun Elly, S.Pd',
                    'position' => 'Duta Literasi Guru',
                    'photo' => 'images/duta-guru.jpg',
                    'description' => 'Memimpin program literasi di kalangan guru dan mengintegrasikan literasi dalam pembelajaran.'
                ]
            ]
        ];

        // Library services and facilities
        $libraryServices = [
            [
                'title' => 'Layanan Sirkulasi',
                'description' => 'Peminjaman dan pengembalian buku untuk siswa, guru, dan staf sekolah.',
                'icon' => 'fas fa-book-open'
            ],
            [
                'title' => 'Layanan Referensi',
                'description' => 'Bantuan pencarian informasi dan referensi untuk tugas dan penelitian.',
                'icon' => 'fas fa-search'
            ],
            [
                'title' => 'Layanan Teknis',
                'description' => 'Pengolahan koleksi, katalogisasi, dan pengelolaan sistem perpustakaan.',
                'icon' => 'fas fa-cogs'
            ],
            [
                'title' => 'Program Literasi',
                'description' => 'Kegiatan membaca, diskusi buku, dan pengembangan budaya literasi.',
                'icon' => 'fas fa-users'
            ]
        ];

        // Library collections
        $collections = [
            'buku_teks' => 'Buku-buku pelajaran dan referensi kurikulum',
            'buku_fiksi' => 'Novel, cerpen, dan karya sastra lainnya',
            'buku_non_fiksi' => 'Ensiklopedia, kamus, dan buku pengetahuan umum',
            'majalah_koran' => 'Publikasi berkala dan surat kabar',
            'digital' => 'E-book dan sumber digital lainnya'
        ];

        return view('frontend.library.index', compact('libraryStructure', 'libraryServices', 'collections'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display the library page with organizational structure.
     */
    public function index()
    {

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

        // Get homepage setting for library data
        $homepageSetting = HomepageSetting::getActive();
        $libraryStructureImage = $homepageSetting ? $homepageSetting->library_structure_image_url : asset('images/STRUKTUR ORGANISASI PERPUSTAKAAN.png');
        
        return view('frontend.library.index', compact('libraryServices', 'libraryStructureImage', 'homepageSetting'));
    }
}

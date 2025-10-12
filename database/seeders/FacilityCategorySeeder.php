<?php

namespace Database\Seeders;

use App\Models\FacilityCategory;
use Illuminate\Database\Seeder;

class FacilityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laboratorium',
                'description' => 'Fasilitas laboratorium untuk praktikum dan penelitian',
                'icon' => 'flask',
                'sort_order' => 1,
            ],
            [
                'name' => 'Perpustakaan',
                'description' => 'Fasilitas perpustakaan dan ruang baca',
                'icon' => 'book',
                'sort_order' => 2,
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Fasilitas olahraga dan lapangan',
                'icon' => 'sport',
                'sort_order' => 3,
            ],
            [
                'name' => 'Kantin',
                'description' => 'Fasilitas kantin dan kafetaria',
                'icon' => 'restaurant',
                'sort_order' => 4,
            ],
            [
                'name' => 'Aula',
                'description' => 'Fasilitas aula dan ruang pertemuan',
                'icon' => 'meeting',
                'sort_order' => 5,
            ],
            [
                'name' => 'Kelas',
                'description' => 'Ruang kelas dan pembelajaran',
                'icon' => 'classroom',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            FacilityCategory::create($category);
        }
    }
}
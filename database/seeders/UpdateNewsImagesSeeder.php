<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class UpdateNewsImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all news
        $news = News::all();
        
        // Available image files
        $availableImages = [
            '1760274960_kegiatan-ekstrakurikuler-semester-genap.jpg',
            '1760274960_prestasi-siswa-di-olimpiade-matematika-tingkat-kabupaten.jpg',
            '1760274960_renovasi-laboratorium-komputer.jpg',
            '1760274960_workshop-pembelajaran-berbasis-teknologi.jpg',
        ];

        foreach ($news as $index => $article) {
            // Assign image based on index
            $imageIndex = $index % count($availableImages);
            $imageName = $availableImages[$imageIndex];
            
            // Update the news record
            $article->update(['image' => $imageName]);
            
            $this->command->info("Updated image for: {$article->title} -> {$imageName}");
        }
    }
}


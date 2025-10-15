<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'subject' => 'Pertanyaan tentang PPDB',
            'message' => 'Selamat pagi, saya ingin bertanya tentang jadwal pendaftaran PPDB untuk tahun ajaran 2024/2025. Kapan pendaftaran dibuka dan apa saja persyaratannya?',
            'is_read' => false,
        ]);

        Message::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '081234567891',
            'subject' => 'Saran untuk Sekolah',
            'message' => 'Saya ingin memberikan saran untuk peningkatan fasilitas sekolah. Mungkin bisa ditambahkan laboratorium komputer yang lebih lengkap untuk mendukung pembelajaran siswa.',
            'is_read' => true,
            'read_at' => now(),
        ]);

        Message::create([
            'name' => 'Ahmad Rahman',
            'email' => 'ahmad@example.com',
            'phone' => '081234567892',
            'subject' => 'Informasi Ekstrakurikuler',
            'message' => 'Apakah ada ekstrakurikuler olahraga seperti sepak bola atau basket di sekolah ini? Anak saya sangat tertarik dengan olahraga.',
            'is_read' => false,
        ]);
    }
}

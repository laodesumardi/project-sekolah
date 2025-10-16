<?php

// Script untuk setup news data di hosting
echo "Setting up news data for hosting...\n";

// Database connection untuk hosting
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Database connection successful\n";
    
    // Check if news table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'news'");
    if ($stmt->rowCount() > 0) {
        echo "News table exists\n";
        
        // Check if there are any news
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM news");
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            echo "No news found, creating sample data...\n";
            
            // Create category
            $stmt = $pdo->prepare("INSERT INTO news_categories (name, slug, description, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->execute(['Berita Umum', 'berita-umum', 'Berita umum sekolah']);
            $categoryId = $pdo->lastInsertId();
            
            // Create user
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->execute(['Admin', 'admin@test.com', password_hash('password', PASSWORD_DEFAULT)]);
            $userId = $pdo->lastInsertId();
            
            // Create news
            $newsData = [
                [
                    'title' => 'Selamat Datang di SMP Negeri 01 Namrole',
                    'slug' => 'selamat-datang-di-smp-negeri-01-namrole',
                    'excerpt' => 'SMP Negeri 01 Namrole membuka pendaftaran siswa baru untuk tahun ajaran 2025/2026.',
                    'content' => 'SMP Negeri 01 Namrole dengan bangga mengumumkan pembukaan pendaftaran siswa baru untuk tahun ajaran 2025/2026.',
                    'is_featured' => 1
                ],
                [
                    'title' => 'PPDB 2025 Telah Dibuka',
                    'slug' => 'ppdb-2025-telah-dibuka',
                    'excerpt' => 'Pendaftaran Peserta Didik Baru (PPDB) 2025 telah dibuka untuk calon siswa baru.',
                    'content' => 'Pendaftaran Peserta Didik Baru (PPDB) 2025 telah dibuka. Calon siswa baru dapat mendaftar melalui website resmi sekolah.',
                    'is_featured' => 0
                ]
            ];
            
            foreach ($newsData as $data) {
                $stmt = $pdo->prepare("INSERT INTO news (title, slug, excerpt, content, category_id, author_id, published_at, is_featured, views, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, 0, NOW(), NOW())");
                $stmt->execute([
                    $data['title'],
                    $data['slug'],
                    $data['excerpt'],
                    $data['content'],
                    $categoryId,
                    $userId,
                    $data['is_featured']
                ]);
                echo "Created news: {$data['title']}\n";
            }
            
            echo "Sample news data created successfully!\n";
        } else {
            echo "News data already exists ({$result['count']} articles)\n";
        }
    } else {
        echo "News table does not exist. Please run migrations first.\n";
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    echo "Please update database credentials in this script.\n";
}

echo "Hosting news setup completed.\n";

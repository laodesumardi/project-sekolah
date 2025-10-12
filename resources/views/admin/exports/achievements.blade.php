<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi Sekolah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #2563eb;
            font-size: 24px;
            margin: 0 0 10px 0;
        }
        
        .header h2 {
            color: #6b7280;
            font-size: 18px;
            margin: 0;
        }
        
        .info {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info p {
            margin: 5px 0;
        }
        
        .year-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .year-title {
            background-color: #2563eb;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .achievement {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            background-color: #ffffff;
        }
        
        .achievement-title {
            font-weight: bold;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .achievement-rank {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        
        .achievement-rank.juara-1 {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .achievement-rank.juara-2 {
            background-color: #e5e7eb;
            color: #6b7280;
        }
        
        .achievement-rank.juara-3 {
            background-color: #fde68a;
            color: #b45309;
        }
        
        .achievement-category {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #dbeafe;
            color: #1e40af;
            margin-bottom: 8px;
        }
        
        .achievement-date {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .achievement-description {
            color: #4b5563;
            font-size: 11px;
            margin-bottom: 8px;
        }
        
        .achievement-participants {
            color: #6b7280;
            font-size: 10px;
            font-style: italic;
        }
        
        .achievement-level {
            color: #6b7280;
            font-size: 10px;
            margin-top: 5px;
        }
        
        .no-achievements {
            text-align: center;
            color: #6b7280;
            font-style: italic;
            padding: 20px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        .summary {
            background-color: #f0f9ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            color: #1e40af;
            font-size: 14px;
        }
        
        .summary p {
            margin: 5px 0;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PRESTASI SEKOLAH</h1>
        <h2>SMP Negeri 01 Namrole</h2>
    </div>

    <div class="info">
        <p><strong>Tanggal Export:</strong> {{ now()->format('d F Y, H:i') }}</p>
        <p><strong>Total Prestasi:</strong> {{ $achievementsByYear->flatten()->count() }} prestasi</p>
        @if($category)
            <p><strong>Kategori:</strong> {{ $category }}</p>
        @endif
        @if($year)
            <p><strong>Tahun:</strong> {{ $year }}</p>
        @endif
        @if($level)
            <p><strong>Tingkat:</strong> {{ $level }}</p>
        @endif
    </div>

    <div class="summary">
        <h3>Ringkasan Prestasi</h3>
        @foreach($achievementsByYear as $year => $yearAchievements)
            <p><strong>{{ $year }}:</strong> {{ $yearAchievements->count() }} prestasi</p>
        @endforeach
    </div>

    @if($achievementsByYear->count() > 0)
        @foreach($achievementsByYear as $year => $yearAchievements)
            <div class="year-section">
                <div class="year-title">Tahun {{ $year }} ({{ $yearAchievements->count() }} prestasi)</div>
                
                @foreach($yearAchievements as $achievement)
                    <div class="achievement">
                        <div class="achievement-title">{{ $achievement->title }}</div>
                        
                        <div class="achievement-rank {{ Str::slug($achievement->rank) }}">
                            {{ $achievement->rank }}
                        </div>
                        
                        <div class="achievement-category">{{ $achievement->category }}</div>
                        
                        <div class="achievement-date">
                            📅 {{ $achievement->date->format('d F Y') }}
                        </div>
                        
                        @if($achievement->description)
                            <div class="achievement-description">{{ Str::limit($achievement->description, 150) }}</div>
                        @endif
                        
                        @if($achievement->participant_names)
                            <div class="achievement-participants">
                                👥 {{ $achievement->participant_names }}
                            </div>
                        @endif
                        
                        <div class="achievement-level">
                            🏆 {{ $achievement->achievement_level }} | {{ $achievement->competition_name }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="no-achievements">
            <p>Tidak ada prestasi yang ditemukan untuk filter ini.</p>
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem SMP Negeri 01 Namrole</p>
        <p>Untuk informasi lebih lanjut, hubungi: (021) 123-4567 | info@smpn01namrole.sch.id</p>
    </div>
</body>
</html>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sekolah</title>
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background-color: #2563eb;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .achievement-item {
            margin-bottom: 10px;
            padding: 10px;
            border-left: 3px solid #2563eb;
            background-color: #f8fafc;
        }
        
        .achievement-title {
            font-weight: bold;
            font-size: 12px;
            color: #1f2937;
            margin-bottom: 3px;
        }
        
        .achievement-date {
            color: #6b7280;
            font-size: 10px;
        }
        
        .event-item {
            margin-bottom: 10px;
            padding: 10px;
            border-left: 3px solid #10b981;
            background-color: #f0fdf4;
        }
        
        .event-title {
            font-weight: bold;
            font-size: 12px;
            color: #1f2937;
            margin-bottom: 3px;
        }
        
        .event-date {
            color: #6b7280;
            font-size: 10px;
        }
        
        .no-data {
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
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN SEKOLAH</h1>
        <h2>SMP Negeri 01 Namrole</h2>
        @if($academicYear)
            <p>Tahun Ajaran: {{ $academicYear->name }}</p>
        @endif
    </div>

    <div class="info">
        <p><strong>Tanggal Laporan:</strong> {{ now()->format('d F Y, H:i') }}</p>
        <p><strong>Periode:</strong> {{ now()->format('F Y') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_students'] }}</div>
            <div class="stat-label">Total Siswa</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_teachers'] }}</div>
            <div class="stat-label">Total Guru</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_extracurriculars'] }}</div>
            <div class="stat-label">Ekstrakurikuler</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_achievements'] }}</div>
            <div class="stat-label">Prestasi</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Prestasi Terbaru</div>
        @if($recentAchievements->count() > 0)
            @foreach($recentAchievements as $achievement)
                <div class="achievement-item">
                    <div class="achievement-title">{{ $achievement->title }}</div>
                    <div class="achievement-date">{{ $achievement->date->format('d F Y') }} - {{ $achievement->rank }}</div>
                </div>
            @endforeach
        @else
            <div class="no-data">
                <p>Tidak ada prestasi terbaru.</p>
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Event Mendatang</div>
        @if($upcomingEvents->count() > 0)
            @foreach($upcomingEvents as $event)
                <div class="event-item">
                    <div class="event-title">{{ $event->title }}</div>
                    <div class="event-date">{{ $event->start_date->format('d F Y') }} @if($event->start_time) - {{ $event->start_time->format('H:i') }@endif</div>
                </div>
            @endforeach
        @else
            <div class="no-data">
                <p>Tidak ada event mendatang.</p>
            </div>
        @endif
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem SMP Negeri 01 Namrole</p>
        <p>Untuk informasi lebih lanjut, hubungi: (021) 123-4567 | info@smpn01namrole.sch.id</p>
    </div>
</body>
</html>


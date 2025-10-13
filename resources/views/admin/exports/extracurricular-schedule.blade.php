<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Ekstrakurikuler</title>
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
        
        .day-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .day-title {
            background-color: #2563eb;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .extracurricular {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            background-color: #ffffff;
        }
        
        .extracurricular-name {
            font-weight: bold;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .extracurricular-category {
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
        
        .extracurricular-schedule {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .extracurricular-description {
            color: #4b5563;
            font-size: 11px;
            margin-bottom: 8px;
        }
        
        .extracurricular-instructor {
            color: #6b7280;
            font-size: 10px;
            font-style: italic;
        }
        
        .extracurricular-participants {
            color: #6b7280;
            font-size: 10px;
            margin-top: 5px;
        }
        
        .no-extracurriculars {
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
        <h1>JADWAL EKSTRAKURIKULER</h1>
        <h2>SMP Negeri 01 Namrole</h2>
    </div>

    <div class="info">
        <p><strong>Tanggal Export:</strong> {{ now()->format('d F Y, H:i') }}</p>
        <p><strong>Total Ekstrakurikuler:</strong> {{ $scheduleByDay->flatten()->count() }} ekstrakurikuler</p>
        @if($category)
            <p><strong>Kategori:</strong> {{ $category }}</p>
        @endif
        @if($day)
            <p><strong>Hari:</strong> {{ ucfirst($day) }}</p>
        @endif
    </div>

    <div class="summary">
        <h3>Ringkasan Jadwal</h3>
        @foreach($scheduleByDay as $dayName => $dayExtracurriculars)
            <p><strong>{{ ucfirst($dayName) }}:</strong> {{ $dayExtracurriculars->count() }} ekstrakurikuler</p>
        @endforeach
    </div>

    @if($scheduleByDay->count() > 0)
        @foreach($scheduleByDay as $dayName => $dayExtracurriculars)
            <div class="day-section">
                <div class="day-title">{{ ucfirst($dayName) }} ({{ $dayExtracurriculars->count() }} ekstrakurikuler)</div>
                
                @foreach($dayExtracurriculars as $extracurricular)
                    <div class="extracurricular">
                        <div class="extracurricular-name">{{ $extracurricular->name }}</div>
                        <div class="extracurricular-category">{{ $extracurricular->category }}</div>
                        
                        <div class="extracurricular-schedule">
                            🕐 {{ $extracurricular->schedule_time->format('H:i') }}
                        </div>
                        
                        @if($extracurricular->description)
                            <div class="extracurricular-description">{{ Str::limit($extracurricular->description, 100) }}</div>
                        @endif
                        
                        @if($extracurricular->instructor)
                            <div class="extracurricular-instructor">
                                👨‍🏫 Pembina: {{ $extracurricular->instructor->name }}
                            </div>
                        @endif
                        
                        @if($extracurricular->max_participants)
                            <div class="extracurricular-participants">
                                👥 Maksimal {{ $extracurricular->max_participants }} peserta
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="no-extracurriculars">
            <p>Tidak ada ekstrakurikuler yang ditemukan untuk filter ini.</p>
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem SMP Negeri 01 Namrole</p>
        <p>Untuk informasi lebih lanjut, hubungi: {{ $homepageSetting->contact_phone ?? '(021) 123-4567' }} | {{ $homepageSetting->contact_email ?? 'info@smpn01namrole.sch.id' }}</p>
    </div>
</body>
</html>


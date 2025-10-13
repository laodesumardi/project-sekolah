<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Akademik</title>
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
        
        .event {
            margin-bottom: 15px;
            padding: 10px;
            border-left: 4px solid #2563eb;
            background-color: #f8fafc;
        }
        
        .event-title {
            font-weight: bold;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .event-date {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .event-description {
            color: #4b5563;
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .event-location {
            color: #6b7280;
            font-size: 10px;
            font-style: italic;
        }
        
        .event-type {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .event-type.activity {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .event-type.exam {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .event-type.deadline {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .event-type.holiday {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        .month-section {
            margin-bottom: 30px;
        }
        
        .month-title {
            background-color: #2563eb;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .no-events {
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
        <h1>KALENDER AKADEMIK</h1>
        <h2>SMP Negeri 01 Namrole</h2>
        @if($academicYear)
            <p>Tahun Ajaran: {{ $academicYear->name }}</p>
        @endif
    </div>

    <div class="info">
        <p><strong>Tanggal Export:</strong> {{ now()->format('d F Y, H:i') }}</p>
        <p><strong>Total Event:</strong> {{ $events->count() }} event</p>
        @if($events->count() > 0)
            <p><strong>Periode:</strong> {{ $events->first()->start_date->format('d F Y') }} - {{ $events->last()->start_date->format('d F Y') }}</p>
        @endif
    </div>

    @if($events->count() > 0)
        @php
            $eventsByMonth = $events->groupBy(function($event) {
                return $event->start_date->format('F Y');
            });
        @endphp

        @foreach($eventsByMonth as $month => $monthEvents)
            <div class="month-section">
                <div class="month-title">{{ $month }}</div>
                
                @foreach($monthEvents as $event)
                    <div class="event">
                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-date">
                            {{ $event->start_date->format('d F Y') }}
                            @if($event->start_time)
                                - {{ $event->start_time->format('H:i') }}
                            @endif
                            @if($event->end_date && $event->end_date != $event->start_date)
                                s/d {{ $event->end_date->format('d F Y') }}
                            @endif
                        </div>
                        
                        @if($event->description)
                            <div class="event-description">{{ $event->description }}</div>
                        @endif
                        
                        @if($event->location)
                            <div class="event-location">📍 {{ $event->location }}</div>
                        @endif
                        
                        <div style="margin-top: 5px;">
                            <span class="event-type {{ $event->event_type }}">{{ ucfirst($event->event_type) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="no-events">
            <p>Tidak ada event yang ditemukan untuk periode ini.</p>
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem SMP Negeri 01 Namrole</p>
        <p>Untuk informasi lebih lanjut, hubungi: {{ $homepageSetting->contact_phone ?? '(021) 123-4567' }} | {{ $homepageSetting->contact_email ?? 'info@smpn01namrole.sch.id' }}</p>
    </div>
</body>
</html>


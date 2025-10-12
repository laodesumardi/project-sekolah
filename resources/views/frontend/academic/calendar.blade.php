@extends('layouts.app')

@section('title', 'Kalender Akademik - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Akademik', 'url' => null],
    ['name' => 'Kalender Akademik', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Kalender Akademik" 
    subtitle="Jadwal kegiatan, ujian, dan libur sekolah tahun {{ $currentYear->year ?? date('Y') }}" 
/>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Calendar Controls -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex items-center gap-4">
                    <h3 class="text-lg font-semibold text-gray-900">Kalender Akademik</h3>
                    <span class="text-sm text-gray-500">Tahun {{ $currentYear->year ?? date('Y') }}</span>
                </div>
                
                <div class="flex gap-2">
                    <button onclick="exportCalendar()" 
                            class="px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- Calendar Legend -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Keterangan Warna</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-red-500 rounded mr-3"></div>
                    <span class="text-sm text-gray-700">Ujian</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-500 rounded mr-3"></div>
                    <span class="text-sm text-gray-700">Kegiatan Sekolah</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-500 rounded mr-3"></div>
                    <span class="text-sm text-gray-700">Libur</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-yellow-500 rounded mr-3"></div>
                    <span class="text-sm text-gray-700">Deadline</span>
                </div>
            </div>
        </div>

        <!-- FullCalendar -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div id="calendar"></div>
        </div>

        <!-- Upcoming Events -->
        @if($events->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kegiatan Mendatang</h3>
                <div class="space-y-4">
                    @foreach($events->take(5) as $event)
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-4 h-4 rounded mr-4" style="background-color: {{ $event->color }}"></div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $event->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $event->formatted_event_type }}</p>
                                @if($event->location)
                                    <p class="text-sm text-gray-500">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $event->location }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $event->start_date->format('d M Y') }}
                                </p>
                                @if($event->start_time)
                                    <p class="text-sm text-gray-500">
                                        {{ $event->start_time->format('H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Event Detail Modal -->
<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full">
            <div class="p-6">
                <!-- Close Button -->
                <button onclick="closeEventModal()" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Content -->
                <div id="eventModalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/api/calendar/events',
        eventClick: function(info) {
            openEventModal(info.event);
        },
        eventDidMount: function(info) {
            // Add tooltip
            info.el.setAttribute('title', info.event.title);
        },
        locale: 'id',
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari'
        }
    });
    calendar.render();
});

function openEventModal(event) {
    // Show modal
    document.getElementById('eventModal').classList.remove('hidden');
    
    // Populate modal content
    const content = `
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">${event.title}</h3>
            <div class="flex items-center mb-2">
                <div class="w-4 h-4 rounded mr-2" style="background-color: ${event.backgroundColor}"></div>
                <span class="text-sm text-gray-600">${event.extendedProps?.formatted_type || 'Event'}</span>
            </div>
            <p class="text-sm text-gray-500">
                ${event.start.toLocaleDateString('id-ID', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                })}
            </p>
            ${event.extendedProps?.description ? `<p class="text-sm text-gray-700 mt-2">${event.extendedProps.description}</p>` : ''}
            ${event.extendedProps?.location ? `<p class="text-sm text-gray-500 mt-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                ${event.extendedProps.location}
            </p>` : ''}
        </div>
    `;
    
    document.getElementById('eventModalContent').innerHTML = content;
}

function closeEventModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

function exportCalendar() {
    window.open('{{ route("academic.calendar.export") }}', '_blank');
}

// Close modal on background click
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEventModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventModal();
    }
});
</script>
@endsection


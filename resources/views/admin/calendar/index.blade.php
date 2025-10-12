@extends('admin.layouts.app')

@section('page-title', 'Kelola Kalender Akademik')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Kalender Akademik</h1>
            <p class="text-gray-600">Kelola jadwal dan event akademik sekolah</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.calendar.export-pdf') }}" 
               class="inline-flex items-center px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('admin.calendar.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Event
            </a>
        </div>
    </div>

    <!-- Calendar View Toggle -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex space-x-4">
                <button id="calendarViewBtn" 
                        class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Kalender
                </button>
                <button id="listViewBtn" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    List
                </button>
            </div>
            <div class="flex items-center space-x-4">
                <select id="academicYearFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                    @endforeach
                </select>
                <select id="eventTypeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Tipe</option>
                    @foreach($eventTypes as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div id="calendarView" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div id="calendar"></div>
    </div>

    <!-- List View -->
    <div id="listView" class="hidden">
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari event..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="w-48">
                    <select name="academic_year_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-48">
                    <select name="event_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Semua Tipe</option>
                        @foreach($eventTypes as $type)
                            <option value="{{ $type }}" {{ request('event_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
            </form>
        </div>

        <!-- Bulk Actions -->
        @if($events->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                <form id="bulkActionForm" method="POST" action="{{ route('admin.calendar.bulk-action') }}">
                    @csrf
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="flex items-center">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <label for="selectAll" class="ml-2 text-sm text-gray-700">Pilih Semua</label>
                        </div>
                        <div class="flex-1">
                            <select name="action" class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Pilih Aksi</option>
                                <option value="delete">Hapus</option>
                            </select>
                        </div>
                        <button type="submit" 
                                class="px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                            Jalankan Aksi
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Events Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if($events->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($events as $event)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                            @if($event->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $event->color }}20; color: {{ $event->color }}">
                                            {{ $event->formatted_event_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div>{{ $event->start_date->format('d M Y') }}</div>
                                        @if($event->end_date && $event->end_date != $event->start_date)
                                            <div class="text-xs text-gray-500">s/d {{ $event->end_date->format('d M Y') }}</div>
                                        @endif
                                        @if($event->start_time)
                                            <div class="text-xs text-gray-500">{{ $event->start_time->format('H:i') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.calendar.edit', $event) }}" 
                                               class="text-secondary-600 hover:text-secondary-900">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button onclick="deleteEvent({{ $event->id }})" 
                                                    class="text-red-600 hover:text-red-900">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada event</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan event baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.calendar.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Event
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Event Modal -->
<div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Detail Event</h3>
                <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="modalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/api/calendar/events',
        eventClick: function(info) {
            showEventModal(info.event);
        },
        dateClick: function(info) {
            // Create new event on date click
            window.location.href = `/admin/calendar/create?date=${info.dateStr}`;
        },
        eventDrop: function(info) {
            // Handle event drag and drop
            updateEventDate(info.event);
        },
        eventResize: function(info) {
            // Handle event resize
            updateEventDate(info.event);
        }
    });
    
    calendar.render();

    // View toggle functionality
    const calendarViewBtn = document.getElementById('calendarViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const calendarView = document.getElementById('calendarView');
    const listView = document.getElementById('listView');

    calendarViewBtn.addEventListener('click', function() {
        calendarView.classList.remove('hidden');
        listView.classList.add('hidden');
        calendarViewBtn.classList.add('bg-primary-500', 'text-white');
        calendarViewBtn.classList.remove('bg-gray-200', 'text-gray-700');
        listViewBtn.classList.add('bg-gray-200', 'text-gray-700');
        listViewBtn.classList.remove('bg-primary-500', 'text-white');
    });

    listViewBtn.addEventListener('click', function() {
        listView.classList.remove('hidden');
        calendarView.classList.add('hidden');
        listViewBtn.classList.add('bg-primary-500', 'text-white');
        listViewBtn.classList.remove('bg-gray-200', 'text-gray-700');
        calendarViewBtn.classList.add('bg-gray-200', 'text-gray-700');
        calendarViewBtn.classList.remove('bg-primary-500', 'text-white');
    });

    // Filter functionality
    const academicYearFilter = document.getElementById('academicYearFilter');
    const eventTypeFilter = document.getElementById('eventTypeFilter');

    academicYearFilter.addEventListener('change', function() {
        calendar.refetchEvents();
    });

    eventTypeFilter.addEventListener('change', function() {
        calendar.refetchEvents();
    });
});

function showEventModal(event) {
    const modal = document.getElementById('eventModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    
    modalTitle.textContent = event.title;
    modalContent.innerHTML = `
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-500">Tanggal</label>
                <p class="text-sm text-gray-900">${event.start.toLocaleDateString()}</p>
            </div>
            ${event.extendedProps.description ? `
                <div>
                    <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                    <p class="text-sm text-gray-900">${event.extendedProps.description}</p>
                </div>
            ` : ''}
            ${event.extendedProps.location ? `
                <div>
                    <label class="block text-sm font-medium text-gray-500">Lokasi</label>
                    <p class="text-sm text-gray-900">${event.extendedProps.location}</p>
                </div>
            ` : ''}
            <div class="flex space-x-3 pt-4">
                <a href="/admin/calendar/${event.id}/edit" 
                   class="flex-1 bg-secondary-500 text-white py-2 px-4 rounded-lg hover:bg-secondary-600 transition-colors duration-200 text-center">
                    Edit
                </a>
                <button onclick="deleteEvent(${event.id})" 
                        class="flex-1 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors duration-200">
                    Hapus
                </button>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
}

function closeEventModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

function updateEventDate(event) {
    fetch(`/api/calendar/events/${event.id}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            start_date: event.start.toISOString().split('T')[0],
            end_date: event.end ? event.end.toISOString().split('T')[0] : null,
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Error updating event:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function deleteEvent(eventId) {
    if (confirm('Apakah Anda yakin ingin menghapus event ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/calendar/${eventId}`;
        form.submit();
    }
}

// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="event_ids[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endsection


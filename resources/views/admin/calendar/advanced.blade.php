@extends('admin.layouts.app')

@section('page-title', 'Kalender Akademik - Advanced')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kalender Akademik - Advanced</h1>
            <p class="text-gray-600">Kelola jadwal dengan drag & drop, click to add, dan color picker</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <button id="exportPdfBtn" 
                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </button>
            <button id="addEventBtn" 
                    class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Event
            </button>
        </div>
    </div>

    <!-- Calendar Controls -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Navigation Controls -->
            <div class="flex items-center space-x-2">
                <button id="prevBtn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button id="nextBtn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <button id="todayBtn" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                    Today
                </button>
            </div>

            <!-- View Controls -->
            <div class="flex items-center space-x-2">
                <select id="viewSelect" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="dayGridMonth">Month</option>
                    <option value="timeGridWeek">Week</option>
                    <option value="timeGridDay">Day</option>
                    <option value="listWeek">List</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Event Legend -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">Legend Event Types</h3>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Activity</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Exam</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-yellow-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Deadline</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-gray-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Holiday</span>
            </div>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div id="calendar"></div>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Tambah Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="eventForm">
                <div class="modal-body">
                    <input type="hidden" id="eventId" name="id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventTitle" class="form-label">Judul Event <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="eventTitle" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventType" class="form-label">Jenis Event <span class="text-danger">*</span></label>
                                <select class="form-select" id="eventType" name="event_type" required>
                                    <option value="">Pilih Jenis Event</option>
                                    <option value="activity">Activity</option>
                                    <option value="exam">Exam</option>
                                    <option value="deadline">Deadline</option>
                                    <option value="holiday">Holiday</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventStartDate" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="eventStartDate" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventEndDate" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="eventEndDate" name="end_date">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventStartTime" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control" id="eventStartTime" name="start_time">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventEndTime" class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control" id="eventEndTime" name="end_time">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventLocation" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" id="eventLocation" name="location">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventColor" class="form-label">Warna Event</label>
                                <div class="d-flex align-items-center">
                                    <input type="color" class="form-control form-control-color" id="eventColor" name="color" value="#3B82F6">
                                    <span class="ms-2" id="colorPreview"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="eventAllDay" name="is_all_day">
                            <label class="form-check-label" for="eventAllDay">
                                All Day Event
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="saveEventBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

<!-- Include FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/id.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    let calendar;
    let currentEvent = null;

    // Initialize FullCalendar
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: '/api/calendar/events',
        editable: true,
        droppable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        
        // Event handlers
        eventClick: function(info) {
            showEventModal(info.event);
        },
        
        dateClick: function(info) {
            showAddEventModal(info.dateStr);
        },
        
        select: function(info) {
            showAddEventModal(info.startStr, info.endStr);
        },
        
        eventDrop: function(info) {
            updateEventDate(info.event);
        },
        
        eventResize: function(info) {
            updateEventDate(info.event);
        },
        
        eventChange: function(info) {
            updateEventDate(info.event);
        }
    });

    calendar.render();

    // Navigation controls
    document.getElementById('prevBtn').addEventListener('click', function() {
        calendar.prev();
    });

    document.getElementById('nextBtn').addEventListener('click', function() {
        calendar.next();
    });

    document.getElementById('todayBtn').addEventListener('click', function() {
        calendar.today();
    });

    // View controls
    document.getElementById('viewSelect').addEventListener('change', function() {
        calendar.changeView(this.value);
    });

    // Add event button
    document.getElementById('addEventBtn').addEventListener('click', function() {
        showAddEventModal();
    });

    // Export PDF button
    document.getElementById('exportPdfBtn').addEventListener('click', function() {
        exportToPDF();
    });

    // Event form submission
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveEvent();
    });

    // Color picker preview
    document.getElementById('eventColor').addEventListener('change', function() {
        document.getElementById('colorPreview').style.backgroundColor = this.value;
    });

    // All day checkbox handler
    document.getElementById('eventAllDay').addEventListener('change', function() {
        const timeInputs = document.querySelectorAll('#eventStartTime, #eventEndTime');
        timeInputs.forEach(input => {
            input.disabled = this.checked;
            if (this.checked) {
                input.value = '';
            }
        });
    });

    function showAddEventModal(startDate = null, endDate = null) {
        currentEvent = null;
        document.getElementById('eventModalLabel').textContent = 'Tambah Event';
        document.getElementById('eventForm').reset();
        document.getElementById('eventId').value = '';
        
        if (startDate) {
            document.getElementById('eventStartDate').value = startDate.split('T')[0];
        }
        if (endDate) {
            document.getElementById('eventEndDate').value = endDate.split('T')[0];
        }
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('eventModal'));
        modal.show();
    }

    function showEventModal(event) {
        currentEvent = event;
        document.getElementById('eventModalLabel').textContent = 'Edit Event';
        
        // Populate form with event data
        document.getElementById('eventId').value = event.id;
        document.getElementById('eventTitle').value = event.title;
        document.getElementById('eventType').value = event.extendedProps.event_type || '';
        document.getElementById('eventDescription').value = event.extendedProps.description || '';
        document.getElementById('eventStartDate').value = event.start.toISOString().split('T')[0];
        document.getElementById('eventEndDate').value = event.end ? event.end.toISOString().split('T')[0] : '';
        document.getElementById('eventStartTime').value = event.start.toTimeString().split(' ')[0].substring(0, 5);
        document.getElementById('eventEndTime').value = event.end ? event.end.toTimeString().split(' ')[0].substring(0, 5) : '';
        document.getElementById('eventLocation').value = event.extendedProps.location || '';
        document.getElementById('eventColor').value = event.color || '#3B82F6';
        document.getElementById('eventAllDay').checked = event.allDay;
        
        // Update color preview
        document.getElementById('colorPreview').style.backgroundColor = event.color || '#3B82F6';
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('eventModal'));
        modal.show();
    }

    function saveEvent() {
        const formData = new FormData(document.getElementById('eventForm'));
        const eventData = Object.fromEntries(formData.entries());
        
        // Convert to JSON
        const jsonData = JSON.stringify(eventData);
        
        const url = currentEvent ? `/api/calendar/events/${currentEvent.id}` : '/api/calendar/events';
        const method = currentEvent ? 'PUT' : 'POST';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: jsonData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
                showNotification('Event berhasil disimpan!', 'success');
            } else {
                showNotification('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat menyimpan event', 'error');
        });
    }

    function updateEventDate(event) {
        const eventData = {
            start_date: event.start.toISOString().split('T')[0],
            end_date: event.end ? event.end.toISOString().split('T')[0] : null,
            start_time: event.start.toTimeString().split(' ')[0].substring(0, 5),
            end_time: event.end ? event.end.toTimeString().split(' ')[0].substring(0, 5) : null
        };
        
        fetch(`/api/calendar/events/${event.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(eventData)
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error updating event:', data.message);
                showNotification('Error updating event: ' + data.message, 'error');
            } else {
                showNotification('Event berhasil diperbarui!', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat memperbarui event', 'error');
        });
    }

    function exportToPDF() {
        window.open('/admin/calendar/export-pdf', '_blank');
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endsection


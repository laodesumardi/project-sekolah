@extends('admin.layouts.app')

@section('page-title', 'Tambah Event Kalender')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Event Kalender</h1>
            <p class="text-gray-600">Tambahkan event baru ke kalender akademik</p>
        </div>
        <a href="{{ route('admin.calendar.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('admin.calendar.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Event -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Event <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror"
                           placeholder="Masukkan judul event"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe Event -->
                <div>
                    <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Event <span class="text-red-500">*</span>
                    </label>
                    <select id="event_type" 
                            name="event_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('event_type') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Tipe Event</option>
                        @foreach($eventTypes as $key => $value)
                            <option value="{{ $key }}" {{ old('event_type') === $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('event_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Ajaran -->
                <div>
                    <label for="academic_year_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Ajaran
                    </label>
                    <select id="academic_year_id" 
                            name="academic_year_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('academic_year_id') border-red-500 @enderror">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="start_date" 
                           name="start_date" 
                           value="{{ old('start_date', request('date')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('start_date') border-red-500 @enderror"
                           required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date" 
                           value="{{ old('end_date') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('end_date') border-red-500 @enderror">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Mulai -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu Mulai
                    </label>
                    <input type="time" 
                           id="start_time" 
                           name="start_time" 
                           value="{{ old('start_time') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Selesai -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu Selesai
                    </label>
                    <input type="time" 
                           id="end_time" 
                           name="end_time" 
                           value="{{ old('end_time') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sepanjang Hari -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               id="is_all_day" 
                               name="is_all_day" 
                               value="1" 
                               {{ old('is_all_day') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                               onchange="toggleTimeFields()">
                        <span class="ml-2 text-sm text-gray-700">Sepanjang Hari</span>
                    </label>
                </div>

                <!-- Lokasi -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('location') border-red-500 @enderror"
                           placeholder="Masukkan lokasi event">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Warna Event
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="color" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', '#3B82F6') }}"
                               class="w-12 h-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('color') border-red-500 @enderror">
                        <div class="flex space-x-2">
                            <button type="button" onclick="setColor('#EF4444')" class="w-6 h-6 bg-red-500 rounded-full border-2 border-gray-300"></button>
                            <button type="button" onclick="setColor('#3B82F6')" class="w-6 h-6 bg-blue-500 rounded-full border-2 border-gray-300"></button>
                            <button type="button" onclick="setColor('#10B981')" class="w-6 h-6 bg-green-500 rounded-full border-2 border-gray-300"></button>
                            <button type="button" onclick="setColor('#F59E0B')" class="w-6 h-6 bg-yellow-500 rounded-full border-2 border-gray-300"></button>
                            <button type="button" onclick="setColor('#8B5CF6')" class="w-6 h-6 bg-purple-500 rounded-full border-2 border-gray-300"></button>
                        </div>
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi event">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.calendar.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    Simpan Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleTimeFields() {
    const isAllDay = document.getElementById('is_all_day').checked;
    const startTimeField = document.getElementById('start_time');
    const endTimeField = document.getElementById('end_time');
    
    if (isAllDay) {
        startTimeField.disabled = true;
        endTimeField.disabled = true;
        startTimeField.value = '';
        endTimeField.value = '';
    } else {
        startTimeField.disabled = false;
        endTimeField.disabled = false;
    }
}

function setColor(color) {
    document.getElementById('color').value = color;
}

// Auto-set end date when start date changes
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = this.value;
    const endDateField = document.getElementById('end_date');
    
    if (startDate && !endDateField.value) {
        endDateField.value = startDate;
    }
});

// Auto-set end time when start time changes
document.getElementById('start_time').addEventListener('change', function() {
    const startTime = this.value;
    const endTimeField = document.getElementById('end_time');
    
    if (startTime && !endTimeField.value) {
        // Add 1 hour to start time
        const startTimeDate = new Date('2000-01-01T' + startTime);
        startTimeDate.setHours(startTimeDate.getHours() + 1);
        endTimeField.value = startTimeDate.toTimeString().slice(0, 5);
    }
});

// Initialize time fields state
document.addEventListener('DOMContentLoaded', function() {
    toggleTimeFields();
});
</script>
@endsection


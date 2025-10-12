{{-- 
    CONTOH PENGGUNAAN BLADE COMPONENTS
    =================================
    
    File ini berisi contoh penggunaan semua Blade components yang telah dibuat.
    Copy kode di bawah ini ke dalam view yang sesuai.
--}}

{{-- 1. ACHIEVEMENT CARD COMPONENT --}}
{{-- 
<x-achievement-card 
    :achievement="$achievement" 
    :show-category="true"
    :show-date="true"
    :show-description="true"
    :show-participants="true"
    :show-level="true"
    size="default" />

<!-- Variasi ukuran -->
<x-achievement-card :achievement="$achievement" size="small" />
<x-achievement-card :achievement="$achievement" size="large" />

<!-- Hanya tampilkan informasi tertentu -->
<x-achievement-card 
    :achievement="$achievement" 
    :show-description="false"
    :show-participants="false" />
--}}

{{-- 2. TEACHER CARD COMPONENT --}}
{{-- 
<x-teacher-card 
    :teacher="$teacher" 
    :show-subject="true"
    :show-education="true"
    :show-experience="true"
    :show-contact="false"
    :show-extracurriculars="false"
    size="default"
    :clickable="true" />

<!-- Untuk sidebar atau list kecil -->
<x-teacher-card :teacher="$teacher" size="small" :show-contact="true" />

<!-- Untuk halaman detail -->
<x-teacher-card 
    :teacher="$teacher" 
    size="large"
    :show-extracurriculars="true"
    :clickable="false" />
--}}

{{-- 3. EXTRACURRICULAR CARD COMPONENT --}}
{{-- 
<x-extracurricular-card 
    :extracurricular="$extracurricular" 
    :show-category="true"
    :show-schedule="true"
    :show-instructor="true"
    :show-participants="true"
    :show-description="true"
    :show-images="false"
    size="default"
    :clickable="true" />

<!-- Dengan preview gambar -->
<x-extracurricular-card 
    :extracurricular="$extracurricular" 
    :show-images="true"
    size="large" />

<!-- Untuk list sederhana -->
<x-extracurricular-card 
    :extracurricular="$extracurricular" 
    size="small"
    :show-description="false"
    :show-participants="false" />
--}}

{{-- 4. CALENDAR EVENT COMPONENT --}}
{{-- 
<x-calendar-event 
    :event="$event" 
    :show-description="true"
    :show-location="true"
    :show-time="true"
    :show-type="true"
    size="default"
    :clickable="true" />

<!-- Untuk timeline -->
<x-calendar-event 
    :event="$event" 
    size="small"
    :show-description="false" />

<!-- Untuk detail view -->
<x-calendar-event 
    :event="$event" 
    size="large"
    :clickable="false" />
--}}

{{-- CONTOH PENGGUNAAN DALAM LOOP --}}
{{-- 
<!-- Achievements Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($achievements as $achievement)
        <x-achievement-card :achievement="$achievement" />
    @endforeach
</div>

<!-- Teachers List -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($teachers as $teacher)
        <x-teacher-card :teacher="$teacher" />
    @endforeach
</div>

<!-- Extracurriculars Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($extracurriculars as $extracurricular)
        <x-extracurricular-card :extracurricular="$extracurricular" />
    @endforeach
</div>

<!-- Calendar Events List -->
<div class="space-y-4">
    @foreach($events as $event)
        <x-calendar-event :event="$event" />
    @endforeach
</div>
--}}

{{-- CONTOH PENGGUNAAN DENGAN FILTER --}}
{{-- 
<!-- Hanya tampilkan prestasi dengan kategori tertentu -->
@foreach($achievements->where('category', 'Akademik') as $achievement)
    <x-achievement-card :achievement="$achievement" />
@endforeach

<!-- Hanya tampilkan guru aktif -->
@foreach($teachers->where('is_active', true) as $teacher)
    <x-teacher-card :teacher="$teacher" />
@endforeach

<!-- Hanya tampilkan ekstrakurikuler aktif -->
@foreach($extracurriculars->where('is_active', true) as $extracurricular)
    <x-extracurricular-card :extracurricular="$extracurricular" />
@endforeach

<!-- Hanya tampilkan event bulan ini -->
@foreach($events->where('start_date', '>=', now()->startOfMonth()) as $event)
    <x-calendar-event :event="$event" />
@endforeach
--}}


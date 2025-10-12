<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Frontend Routes
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities');
Route::get('/fasilitas/{facility}', [FacilityController::class, 'show'])->name('facilities.show');

// PPDB Routes
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [PPDBController::class, 'index'])->name('index');
    Route::get('/daftar', [PPDBController::class, 'form'])->name('form');
    Route::post('/daftar/step/{step}', [PPDBController::class, 'storeStep'])->name('store-step');
    Route::post('/daftar/submit', [PPDBController::class, 'submit'])->name('submit');
    Route::get('/konfirmasi/{registration_number}', [PPDBController::class, 'confirmation'])->name('confirmation');
    Route::get('/status', [PPDBController::class, 'statusForm'])->name('status');
    Route::post('/status', [PPDBController::class, 'checkStatus'])->name('check-status');
    Route::get('/pengumuman', [PPDBController::class, 'announcement'])->name('announcement');
});

// News Routes
Route::get('/berita', [NewsController::class, 'index'])->name('news');
Route::get('/berita/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/berita/kategori/{category}', [NewsController::class, 'category'])->name('news.category');
Route::get('/berita/tag/{tag}', [NewsController::class, 'tag'])->name('news.tag');
Route::get('/feed', [NewsController::class, 'feed'])->name('news.feed');

// Gallery Routes
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
Route::get('/galeri/data', [GalleryController::class, 'getGalleryData'])->name('gallery.data');
Route::get('/galeri/{gallery}/download', [GalleryController::class, 'download'])->name('gallery.download');

// Library Routes
Route::get('/perpustakaan', [LibraryController::class, 'index'])->name('library');

// Academic Routes
Route::prefix('akademik')->name('academic.')->group(function () {
    Route::get('/kurikulum', [AcademicController::class, 'curriculum'])->name('curriculum');
    Route::get('/ekstrakurikuler', [AcademicController::class, 'extracurriculars'])->name('extracurriculars');
    Route::get('/ekstrakurikuler/{extracurricular}', [AcademicController::class, 'extracurricularDetail'])->name('extracurricular.detail');
    Route::get('/guru', [AcademicController::class, 'teachers'])->name('teachers');
    Route::get('/guru/{teacher}', [AcademicController::class, 'teacherDetail'])->name('teacher.detail');
    Route::get('/kalender', [AcademicController::class, 'calendar'])->name('calendar');
    Route::get('/prestasi', [AcademicController::class, 'achievements'])->name('achievements');
    
    // Detail routes
    Route::get('/ekstrakurikuler/{extracurricular}', [AcademicController::class, 'extracurricularDetail'])->name('extracurricular-detail');
    Route::get('/guru/{teacher}', [AcademicController::class, 'teacherDetail'])->name('teacher-detail');
    
    // Download/Export routes
    Route::get('/silabus/{subject}/download', [AcademicController::class, 'downloadSyllabus'])->name('syllabus.download');
    Route::get('/jadwal-ekskul/export', [AcademicController::class, 'exportExtracurricularSchedule'])->name('extracurricular.export');
    Route::get('/kalender/export', [AcademicController::class, 'exportCalendar'])->name('calendar.export');
});

// API Routes for Modal
Route::get('/api/facilities/{facility}', [FacilityController::class, 'apiShow'])->name('api.facilities.show');


// Placeholder routes for navigation
Route::get('/tentang', function () {
    return redirect()->route('about');
})->name('tentang');

Route::get('/akademik', function () {
    return redirect()->route('academic.curriculum');
})->name('akademik');


Route::get('/kontak', function () {
    return view('frontend.contact.index');
})->name('kontak');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
            // Admin Routes
            Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
                Route::get('/dashboard', function () {
                    return view('admin.dashboard');
                })->name('dashboard');

                // Facilities Management
                Route::resource('facilities', \App\Http\Controllers\Admin\FacilityController::class);
                Route::post('facilities/{facility}/toggle-status', [\App\Http\Controllers\Admin\FacilityController::class, 'toggleStatus'])->name('facilities.toggle-status');
                Route::post('facilities/bulk-action', [\App\Http\Controllers\Admin\FacilityController::class, 'bulkAction'])->name('facilities.bulk-action');
                Route::get('facilities/export', [\App\Http\Controllers\Admin\FacilityController::class, 'export'])->name('facilities.export');


                // News Management
                Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
                Route::post('news/{news}/toggle-featured', [\App\Http\Controllers\Admin\NewsController::class, 'toggleFeatured'])->name('news.toggle-featured');
                Route::post('news/bulk-action', [\App\Http\Controllers\Admin\NewsController::class, 'bulkAction'])->name('news.bulk-action');

                // PPDB Management
                Route::prefix('ppdb')->name('ppdb.')->group(function () {
                    Route::get('/dashboard', [\App\Http\Controllers\Admin\PPDBController::class, 'dashboard'])->name('dashboard');
                    Route::get('/pendaftar', [\App\Http\Controllers\Admin\PPDBController::class, 'index'])->name('index');
                    Route::post('/pendaftar', [\App\Http\Controllers\Admin\PPDBController::class, 'store'])->name('store');
                    Route::get('/pendaftar/{registration}/edit', [\App\Http\Controllers\Admin\PPDBController::class, 'edit'])->name('edit');
                    Route::put('/pendaftar/{registration}', [\App\Http\Controllers\Admin\PPDBController::class, 'update'])->name('update');
                    Route::get('/pendaftar/{registration}', [\App\Http\Controllers\Admin\PPDBController::class, 'show'])->name('show');
                    Route::put('/pendaftar/{registration}/status', [\App\Http\Controllers\Admin\PPDBController::class, 'updateStatus'])->name('update-status');
                    Route::post('/pendaftar/bulk-status', [\App\Http\Controllers\Admin\PPDBController::class, 'bulkUpdateStatus'])->name('bulk-status');
                    Route::post('/pendaftar/bulk-delete', [\App\Http\Controllers\Admin\PPDBController::class, 'bulkDelete'])->name('bulk-delete');
                    Route::delete('/pendaftar/{registration}', [\App\Http\Controllers\Admin\PPDBController::class, 'destroy'])->name('destroy');
                    Route::get('/export', [\App\Http\Controllers\Admin\PPDBController::class, 'export'])->name('export');
                    Route::get('/statistics', [\App\Http\Controllers\Admin\PPDBController::class, 'statistics'])->name('statistics');
                    Route::post('/quick-register', [\App\Http\Controllers\Admin\PPDBController::class, 'quickRegister'])->name('quick-register');
                });

                // PPDB Settings
                Route::prefix('ppdb-settings')->name('ppdb-settings.')->group(function () {
                    Route::get('/', [\App\Http\Controllers\Admin\PPDBSettingController::class, 'index'])->name('index');
                    Route::post('/', [\App\Http\Controllers\Admin\PPDBSettingController::class, 'store'])->name('store');
                    Route::post('/toggle-status', [\App\Http\Controllers\Admin\PPDBSettingController::class, 'toggleStatus'])->name('toggle-status');
                    Route::get('/quota-statistics', [\App\Http\Controllers\Admin\PPDBSettingController::class, 'quotaStatistics'])->name('quota-statistics');
                });

                // Gallery Management
                Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
                Route::post('gallery/bulk-upload', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkUpload'])->name('gallery.bulk-upload');
                Route::post('gallery/update-sort', [\App\Http\Controllers\Admin\GalleryController::class, 'updateSortOrder'])->name('gallery.update-sort');
                Route::post('gallery/{gallery}/toggle-active', [\App\Http\Controllers\Admin\GalleryController::class, 'toggleActive'])->name('gallery.toggle-active');
                Route::post('gallery/bulk-action', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkAction'])->name('gallery.bulk-action');

                // Tags Management
                Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
                Route::get('tags/autocomplete', [\App\Http\Controllers\Admin\TagController::class, 'autocomplete'])->name('tags.autocomplete');
                Route::post('tags/create-ajax', [\App\Http\Controllers\Admin\TagController::class, 'createAjax'])->name('tags.create-ajax');

                // Academic Management
                Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
                Route::post('subjects/{subject}/toggle-active', [\App\Http\Controllers\Admin\SubjectController::class, 'toggleActive'])->name('subjects.toggle-active');
                Route::post('subjects/bulk-action', [\App\Http\Controllers\Admin\SubjectController::class, 'bulkAction'])->name('subjects.bulk-action');

                // Extracurricular Management
                Route::resource('extracurriculars', \App\Http\Controllers\Admin\ExtracurricularController::class);
                Route::post('extracurriculars/{extracurricular}/toggle-active', [\App\Http\Controllers\Admin\ExtracurricularController::class, 'toggleActive'])->name('extracurriculars.toggle-active');
                Route::post('extracurriculars/bulk-action', [\App\Http\Controllers\Admin\ExtracurricularController::class, 'bulkAction'])->name('extracurriculars.bulk-action');

                // Calendar Management
                Route::resource('calendar', \App\Http\Controllers\Admin\CalendarController::class);
                Route::get('calendar/events', [\App\Http\Controllers\Admin\CalendarController::class, 'getEvents'])->name('calendar.events');
                Route::post('calendar/events', [\App\Http\Controllers\Admin\CalendarController::class, 'createEvent'])->name('calendar.events.create');
                Route::put('calendar/events/{calendar}', [\App\Http\Controllers\Admin\CalendarController::class, 'updateEvent'])->name('calendar.events.update');
                Route::delete('calendar/events/{calendar}', [\App\Http\Controllers\Admin\CalendarController::class, 'deleteEvent'])->name('calendar.events.delete');
                Route::get('calendar/export-pdf', [\App\Http\Controllers\Admin\CalendarController::class, 'exportPdf'])->name('calendar.export-pdf');
                Route::post('calendar/bulk-action', [\App\Http\Controllers\Admin\CalendarController::class, 'bulkAction'])->name('calendar.bulk-action');

                // Achievement Management
                Route::resource('achievements', \App\Http\Controllers\Admin\AchievementController::class);
                Route::post('achievements/{achievement}/toggle-featured', [\App\Http\Controllers\Admin\AchievementController::class, 'toggleFeatured'])->name('achievements.toggle-featured');
                Route::post('achievements/bulk-action', [\App\Http\Controllers\Admin\AchievementController::class, 'bulkAction'])->name('achievements.bulk-action');

                // Export Routes
                Route::prefix('export')->name('export.')->group(function () {
                    Route::get('calendar', [\App\Http\Controllers\Admin\ExportController::class, 'exportCalendar'])->name('calendar');
                    Route::get('extracurricular-schedule', [\App\Http\Controllers\Admin\ExportController::class, 'exportExtracurricularSchedule'])->name('extracurricular-schedule');
                    Route::get('achievements', [\App\Http\Controllers\Admin\ExportController::class, 'exportAchievements'])->name('achievements');
                    Route::get('subjects', [\App\Http\Controllers\Admin\ExportController::class, 'exportSubjects'])->name('subjects');
                    Route::get('school-report', [\App\Http\Controllers\Admin\ExportController::class, 'exportSchoolReport'])->name('school-report');
                });
            });
    
    // Teacher Routes
    Route::middleware('role:teacher')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');
    });
    
    // Student Routes
    Route::middleware('role:student')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            return view('siswa.dashboard');
        })->name('dashboard');
    });
    
    // Parent Routes
    Route::middleware('role:parent')->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/dashboard', function () {
            return view('orangtua.dashboard');
        })->name('dashboard');
    });
});

require __DIR__.'/auth.php';

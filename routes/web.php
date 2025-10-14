<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\DocumentController;
use App\Http\Controllers\Student\ScheduleController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\DocumentController as TeacherDocumentController;
use App\Http\Controllers\Teacher\CertificationController;
use App\Http\Controllers\Teacher\ClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Frontend Routes
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::get('/akreditasi', [\App\Http\Controllers\AccreditationController::class, 'index'])->name('accreditation');
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities');
Route::get('/fasilitas/{facility}', [FacilityController::class, 'show'])->name('facilities.show');

// PPDB Routes
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [PPDBController::class, 'index'])->name('index');
    Route::get('/daftar', [PPDBController::class, 'form'])->name('form');
    Route::post('/daftar/submit', [PPDBController::class, 'submit'])->name('submit');
    Route::get('/konfirmasi/{registration_number}', [PPDBController::class, 'confirmation'])->name('confirmation');
    Route::get('/download-form/{registration_number}', [PPDBController::class, 'downloadForm'])->name('download-form');
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



Route::middleware(['auth', 'active'])->group(function () {
    // Dashboard untuk semua user
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'teacher':
                return redirect()->route('teacher.dashboard');
            case 'student':
                return redirect()->route('siswa.dashboard');
            case 'parent':
                return redirect()->route('orangtua.dashboard');
            default:
                return redirect()->route('admin.dashboard');
        }
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
            // Admin Routes
            Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
                Route::get('/dashboard', function () {
                    return view('admin.dashboard');
                })->name('dashboard');

                // Homepage Settings Management
                Route::get('/homepage-settings', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'index'])->name('homepage-settings.index');
                Route::get('/homepage-settings/edit', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'edit'])->name('homepage-settings.edit');
                Route::put('/homepage-settings', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'update'])->name('homepage-settings.update');
                Route::post('/homepage-settings/ajax-update', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'updateAjax'])->name('homepage-settings.ajax-update');

                // About Page Settings Management
                Route::get('/about-page-settings', [\App\Http\Controllers\Admin\AboutPageSettingController::class, 'index'])->name('about-page-settings.index');
                Route::get('/about-page-settings/edit', [\App\Http\Controllers\Admin\AboutPageSettingController::class, 'edit'])->name('about-page-settings.edit');
                Route::put('/about-page-settings', [\App\Http\Controllers\Admin\AboutPageSettingController::class, 'update'])->name('about-page-settings.update');

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
    Route::middleware(['auth', 'teacher'])->prefix('guru')->name('teacher.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [TeacherDashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::get('/dashboard/schedule-today', [TeacherDashboardController::class, 'getScheduleToday'])->name('dashboard.schedule-today');
        Route::get('/dashboard/pending-tasks', [TeacherDashboardController::class, 'getPendingTasks'])->name('dashboard.pending-tasks');
        Route::get('/dashboard/activities', [TeacherDashboardController::class, 'getActivities'])->name('dashboard.activities');
        
        // Profile
        Route::get('/profil', [TeacherProfileController::class, 'show'])->name('profile.show');
        Route::get('/profil/edit', [TeacherProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [TeacherProfileController::class, 'update'])->name('profile.update');
        Route::post('/profil/photo', [TeacherProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::put('/profil/password', [TeacherProfileController::class, 'updatePassword'])->name('profile.password');
        Route::get('/profil/portfolio', [TeacherProfileController::class, 'portfolio'])->name('profile.portfolio');
        Route::get('/profil/keamanan', [TeacherProfileController::class, 'security'])->name('profile.security');
        Route::get('/profil/sessions', [TeacherProfileController::class, 'sessions'])->name('profile.sessions');
        Route::post('/profil/logout-devices', [TeacherProfileController::class, 'logoutOtherDevices'])->name('profile.logout-devices');
        Route::put('/profil/privacy', [TeacherProfileController::class, 'updatePrivacy'])->name('profile.privacy');
        
        // Documents
        Route::resource('dokumen', TeacherDocumentController::class);
        Route::get('/dokumen/{id}/download', [TeacherDocumentController::class, 'download'])->name('dokumen.download');
        
        // Certifications
        Route::resource('sertifikasi', CertificationController::class);
        
            // Classes
            Route::get('/kelas', [ClassController::class, 'index'])->name('kelas.index');
            Route::get('/kelas/{class}', [ClassController::class, 'show'])->name('kelas.show');
            Route::get('/kelas/{class}/analytics', [ClassController::class, 'analytics'])->name('kelas.analytics');
            Route::get('/kelas/{class}/export/{format}', [ClassController::class, 'export'])->name('kelas.export');
            Route::get('/kelas/{class}/attendance', [ClassController::class, 'inputAttendance'])->name('kelas.attendance');
            Route::post('/kelas/{class}/attendance', [ClassController::class, 'storeAttendance'])->name('kelas.attendance.store');
            Route::get('/kelas/{class}/grades', [ClassController::class, 'inputGrades'])->name('kelas.grades');
            Route::post('/kelas/{class}/grades', [ClassController::class, 'storeGrades'])->name('kelas.grades.store');
            Route::get('/kelas/{class}/student/{student}', [ClassController::class, 'studentDetails'])->name('kelas.student.details');
            
            // Learning
            Route::get('/pembelajaran', [App\Http\Controllers\Teacher\LearningController::class, 'index'])->name('pembelajaran.index');
            Route::get('/pembelajaran/create', [App\Http\Controllers\Teacher\LearningController::class, 'create'])->name('pembelajaran.create');
            Route::post('/pembelajaran', [App\Http\Controllers\Teacher\LearningController::class, 'store'])->name('pembelajaran.store');
            Route::get('/pembelajaran/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'show'])->name('pembelajaran.show');
            Route::get('/pembelajaran/{id}/edit', [App\Http\Controllers\Teacher\LearningController::class, 'edit'])->name('pembelajaran.edit');
            Route::put('/pembelajaran/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'update'])->name('pembelajaran.update');
            Route::post('/pembelajaran/{id}/update', [App\Http\Controllers\Teacher\LearningController::class, 'update'])->name('pembelajaran.update.post');
            Route::delete('/pembelajaran/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'destroy'])->name('pembelajaran.destroy');
            Route::post('/pembelajaran/{id}/publish', [App\Http\Controllers\Teacher\LearningController::class, 'publish'])->name('pembelajaran.publish');
            
            // Grades/Assessment
            Route::get('/penilaian', [App\Http\Controllers\Teacher\GradeController::class, 'index'])->name('penilaian.index');
            Route::get('/penilaian/create', [App\Http\Controllers\Teacher\GradeController::class, 'create'])->name('penilaian.create');
            Route::post('/penilaian', [App\Http\Controllers\Teacher\GradeController::class, 'store'])->name('penilaian.store');
            Route::get('/penilaian/{id}/edit', [App\Http\Controllers\Teacher\GradeController::class, 'edit'])->name('penilaian.edit');
            Route::put('/penilaian/{id}', [App\Http\Controllers\Teacher\GradeController::class, 'update'])->name('penilaian.update');
            Route::delete('/penilaian/{id}', [App\Http\Controllers\Teacher\GradeController::class, 'destroy'])->name('penilaian.destroy');
            Route::get('/penilaian/kelas/{class}', [App\Http\Controllers\Teacher\GradeController::class, 'showClass'])->name('penilaian.class');
            Route::get('/penilaian/analytics', [App\Http\Controllers\Teacher\GradeController::class, 'analytics'])->name('penilaian.analytics');
            Route::post('/penilaian/export', [App\Http\Controllers\Teacher\GradeController::class, 'export'])->name('penilaian.export');
            
            // Forum & Discussion
            Route::get('/forum', [App\Http\Controllers\Teacher\ForumController::class, 'index'])->name('forum.index');
            Route::get('/forum/create', [App\Http\Controllers\Teacher\ForumController::class, 'create'])->name('forum.create');
            Route::post('/forum', [App\Http\Controllers\Teacher\ForumController::class, 'store'])->name('forum.store');
            Route::get('/forum/{id}', [App\Http\Controllers\Teacher\ForumController::class, 'show'])->name('forum.show');
            Route::get('/forum/{id}/edit', [App\Http\Controllers\Teacher\ForumController::class, 'edit'])->name('forum.edit');
            Route::put('/forum/{id}', [App\Http\Controllers\Teacher\ForumController::class, 'update'])->name('forum.update');
            Route::delete('/forum/{id}', [App\Http\Controllers\Teacher\ForumController::class, 'destroy'])->name('forum.destroy');
            Route::get('/forum/kategori/{category}', [App\Http\Controllers\Teacher\ForumController::class, 'category'])->name('forum.category');
            Route::post('/forum/{id}/reply', [App\Http\Controllers\Teacher\ForumController::class, 'reply'])->name('forum.reply');
            Route::post('/forum/{id}/like', [App\Http\Controllers\Teacher\ForumController::class, 'like'])->name('forum.like');
            Route::post('/forum/{id}/pin', [App\Http\Controllers\Teacher\ForumController::class, 'pin'])->name('forum.pin');
            Route::get('/forum/search', [App\Http\Controllers\Teacher\ForumController::class, 'search'])->name('forum.search');
    });
    
    // Student Routes
    Route::middleware(['auth', 'student'])->prefix('siswa')->name('student.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::get('/dashboard/activities', [DashboardController::class, 'getActivities'])->name('dashboard.activities');
        
        
        // Schedule
        Route::get('/jadwal', [ScheduleController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/{date}', [ScheduleController::class, 'show'])->name('jadwal.show');
        Route::get('/jadwal/export/pdf', [ScheduleController::class, 'exportPdf'])->name('jadwal.export.pdf');
        Route::get('/jadwal/export/excel', [ScheduleController::class, 'exportExcel'])->name('jadwal.export.excel');
        
        // Materials
        Route::get('/materi', [App\Http\Controllers\Student\MaterialController::class, 'index'])->name('materi.index');
        Route::get('/materi/{id}', [App\Http\Controllers\Student\MaterialController::class, 'show'])->name('materi.show');
        Route::get('/materi/{id}/download', [App\Http\Controllers\Student\MaterialController::class, 'download'])->name('materi.download');
        Route::post('/materi/{id}/favorite', [App\Http\Controllers\Student\MaterialController::class, 'toggleFavorite'])->name('materi.favorite');
        Route::post('/materi/{id}/comment', [App\Http\Controllers\Student\MaterialController::class, 'addComment'])->name('materi.comment');
        
            // Learning
            Route::get('/pembelajaran', [App\Http\Controllers\Student\LearningController::class, 'index'])->name('pembelajaran.index');
            Route::get('/pembelajaran/{id}', [App\Http\Controllers\Student\LearningController::class, 'show'])->name('pembelajaran.show');
            Route::post('/pembelajaran/{id}/start', [App\Http\Controllers\Student\LearningController::class, 'start'])->name('pembelajaran.start');
            Route::post('/pembelajaran/{id}/complete', [App\Http\Controllers\Student\LearningController::class, 'complete'])->name('pembelajaran.complete');
            Route::post('/pembelajaran/{id}/notes', [App\Http\Controllers\Student\LearningController::class, 'saveNotes'])->name('pembelajaran.notes');
            Route::post('/pembelajaran/{id}/quiz', [App\Http\Controllers\Student\LearningController::class, 'submitQuiz'])->name('pembelajaran.quiz');
            
            // Assignments & Exams
            Route::get('/tugas', [App\Http\Controllers\Student\AssignmentController::class, 'index'])->name('tugas.index');
            Route::get('/tugas/{id}', [App\Http\Controllers\Student\AssignmentController::class, 'show'])->name('tugas.show');
            Route::post('/tugas/{id}/submit', [App\Http\Controllers\Student\AssignmentController::class, 'submit'])->name('tugas.submit');
            Route::get('/tugas/{id}/results', [App\Http\Controllers\Student\AssignmentController::class, 'results'])->name('tugas.results');
            
            // Grades & Reports
            Route::get('/nilai', [App\Http\Controllers\Student\GradeController::class, 'index'])->name('nilai.index');
            Route::get('/nilai/{id}', [App\Http\Controllers\Student\GradeController::class, 'show'])->name('nilai.show');
            Route::get('/nilai/rapor/report', [App\Http\Controllers\Student\GradeController::class, 'report'])->name('nilai.report');
            Route::post('/nilai/rapor/download', [App\Http\Controllers\Student\GradeController::class, 'downloadReport'])->name('nilai.download');
            
            // Attendance
            Route::get('/absensi', [App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('absensi.index');
            Route::get('/absensi/{id}', [App\Http\Controllers\Student\AttendanceController::class, 'show'])->name('absensi.show');
            Route::get('/absensi/kalender/calendar', [App\Http\Controllers\Student\AttendanceController::class, 'calendar'])->name('absensi.calendar');
            Route::post('/absensi/export', [App\Http\Controllers\Student\AttendanceController::class, 'export'])->name('absensi.export');
            
            // Documents
            Route::get('/dokumen', [App\Http\Controllers\Student\DocumentController::class, 'index'])->name('documents.index');
            Route::get('/dokumen/{id}', [App\Http\Controllers\Student\DocumentController::class, 'show'])->name('documents.show');
            Route::post('/dokumen', [App\Http\Controllers\Student\DocumentController::class, 'upload'])->name('documents.upload');
            Route::get('/dokumen/{id}/download', [App\Http\Controllers\Student\DocumentController::class, 'download'])->name('documents.download');
            Route::delete('/dokumen/{id}', [App\Http\Controllers\Student\DocumentController::class, 'delete'])->name('documents.delete');
            
            // Forum
            Route::get('/forum', [App\Http\Controllers\Student\ForumController::class, 'index'])->name('forum.index');
            Route::get('/forum/create', [App\Http\Controllers\Student\ForumController::class, 'create'])->name('forum.create');
            Route::post('/forum', [App\Http\Controllers\Student\ForumController::class, 'store'])->name('forum.store');
            Route::get('/forum/{id}', [App\Http\Controllers\Student\ForumController::class, 'show'])->name('forum.show');
            Route::post('/forum/{id}/reply', [App\Http\Controllers\Student\ForumController::class, 'reply'])->name('forum.reply');
            Route::post('/forum/{type}/{id}/like', [App\Http\Controllers\Student\ForumController::class, 'like'])->name('forum.like');
            Route::post('/forum/{topicId}/solution/{replyId}', [App\Http\Controllers\Student\ForumController::class, 'markSolution'])->name('forum.solution');
            
            // Profile
            Route::get('/profil', [App\Http\Controllers\Student\ProfileController::class, 'index'])->name('profil.index');
            Route::get('/profil/edit', [App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profil.edit');
            Route::post('/profil', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profil.update');
            Route::get('/profil/keamanan', [App\Http\Controllers\Student\ProfileController::class, 'security'])->name('profil.security');
            Route::post('/profil/change-password', [App\Http\Controllers\Student\ProfileController::class, 'changePassword'])->name('profil.change-password');
            Route::post('/profil/privacy', [App\Http\Controllers\Student\ProfileController::class, 'updatePrivacy'])->name('profil.privacy');
            
            // Settings
            Route::get('/pengaturan', [App\Http\Controllers\Student\SettingsController::class, 'index'])->name('pengaturan.index');
            Route::post('/pengaturan/general', [App\Http\Controllers\Student\SettingsController::class, 'updateGeneral'])->name('pengaturan.general');
            Route::post('/pengaturan/notifications', [App\Http\Controllers\Student\SettingsController::class, 'updateNotifications'])->name('pengaturan.notifications');
            Route::post('/pengaturan/privacy', [App\Http\Controllers\Student\SettingsController::class, 'updatePrivacy'])->name('pengaturan.privacy');
            Route::post('/pengaturan/account', [App\Http\Controllers\Student\SettingsController::class, 'updateAccount'])->name('pengaturan.account');
            Route::post('/pengaturan/password', [App\Http\Controllers\Student\SettingsController::class, 'changePassword'])->name('pengaturan.password');
            Route::get('/pengaturan/export', [App\Http\Controllers\Student\SettingsController::class, 'exportSettings'])->name('pengaturan.export');
            Route::post('/pengaturan/reset', [App\Http\Controllers\Student\SettingsController::class, 'resetSettings'])->name('pengaturan.reset');
            
            // Notifications
            Route::get('/notifikasi', [App\Http\Controllers\Student\NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifikasi/{id}/mark-read', [App\Http\Controllers\Student\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
            Route::post('/notifikasi/mark-all-read', [App\Http\Controllers\Student\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
            Route::get('/notifikasi/unread-count', [App\Http\Controllers\Student\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
            Route::get('/notifikasi/recent', [App\Http\Controllers\Student\NotificationController::class, 'getRecent'])->name('notifications.recent');
            
            // Messages
            Route::get('/pesan', [App\Http\Controllers\Student\MessageController::class, 'index'])->name('messages.index');
            Route::get('/pesan/{id}', [App\Http\Controllers\Student\MessageController::class, 'show'])->name('messages.show');
            Route::post('/pesan', [App\Http\Controllers\Student\MessageController::class, 'store'])->name('messages.store');
            Route::post('/pesan/{id}/mark-read', [App\Http\Controllers\Student\MessageController::class, 'markAsRead'])->name('messages.mark-read');
            Route::post('/pesan/mark-all-read', [App\Http\Controllers\Student\MessageController::class, 'markAllAsRead'])->name('messages.mark-all-read');
            Route::get('/pesan/unread-count', [App\Http\Controllers\Student\MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
            Route::get('/pesan/recent', [App\Http\Controllers\Student\MessageController::class, 'getRecent'])->name('messages.recent');
            
    });
    
    // Parent Routes
    Route::middleware('role:parent')->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/dashboard', function () {
            return view('orangtua.dashboard');
        })->name('dashboard');
    });
});

require __DIR__.'/auth.php';

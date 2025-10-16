<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\FacilityController;
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
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\LearningMaterialController;
use App\Http\Controllers\Teacher\ScheduleController as TeacherScheduleController;
use App\Http\Controllers\Admin\UserRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// PPDB Routes
Route::get('/ppdb', [\App\Http\Controllers\PPDBController::class, 'index'])->name('ppdb.index');
Route::post('/ppdb', [\App\Http\Controllers\PPDBController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/success/{registrationNumber}', [\App\Http\Controllers\PPDBController::class, 'success'])->name('ppdb.success');
Route::get('/ppdb/status', [\App\Http\Controllers\PPDBController::class, 'checkStatusForm'])->name('ppdb.status');
Route::post('/ppdb/status', [\App\Http\Controllers\PPDBController::class, 'checkStatus'])->name('ppdb.check-status');

// Registration Routes (for user account registration)
Route::get('/register', [\App\Http\Controllers\RegistrationController::class, 'show'])->name('register');
Route::post('/register', [\App\Http\Controllers\RegistrationController::class, 'store'])->name('register.store');
Route::get('/register/success/{registrationNumber}', [\App\Http\Controllers\RegistrationController::class, 'success'])->name('registration.success');
Route::get('/register/verify/{token}', [\App\Http\Controllers\RegistrationController::class, 'verifyEmail'])->name('registration.verify');
Route::get('/register/status', function() {
    return view('auth.registration-status');
})->name('registration.status');
Route::post('/register/status', [\App\Http\Controllers\RegistrationController::class, 'checkStatus'])->name('registration.check-status');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Frontend Routes
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [\App\Http\Controllers\MessageController::class, 'store'])->name('contact.message');
Route::get('/akreditasi', [\App\Http\Controllers\AccreditationController::class, 'index'])->name('accreditation');
Route::get('/gambar-section', function () {
    return view('section-images.index');
})->name('section-images');


// News Routes
Route::get('/berita', [NewsController::class, 'index'])->name('news');
Route::get('/berita/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/berita/kategori/{category}', [NewsController::class, 'category'])->name('news.category');
Route::get('/berita/tag/{tag}', [NewsController::class, 'tag'])->name('news.tag');

// Achievement Routes
Route::get('/prestasi', [\App\Http\Controllers\AchievementController::class, 'index'])->name('achievements');
Route::get('/prestasi/statistik', [\App\Http\Controllers\AchievementStatisticsController::class, 'index'])->name('achievements.statistics');
Route::get('/prestasi/{slug}', [\App\Http\Controllers\AchievementController::class, 'show'])->name('achievements.show');
Route::get('/prestasi/filter', [\App\Http\Controllers\AchievementController::class, 'filter'])->name('achievements.filter');
Route::get('/feed', [NewsController::class, 'feed'])->name('news.feed');

// Gallery Routes
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{slug}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/galeri/filter', [GalleryController::class, 'filter'])->name('gallery.filter');


// Library Routes
Route::get('/perpustakaan', [LibraryController::class, 'index'])->name('library');

// Facility Routes
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/fasilitas/{slug}', [FacilityController::class, 'show'])->name('facilities.show');
Route::get('/fasilitas/filter', [FacilityController::class, 'filter'])->name('facilities.filter');

// Academic Routes
Route::prefix('akademik')->name('academic.')->group(function () {
    Route::get('/kurikulum', [AcademicController::class, 'curriculum'])->name('curriculum');
    Route::get('/guru', [AcademicController::class, 'teachers'])->name('teachers');
    Route::get('/guru/{teacher}', [AcademicController::class, 'teacherDetail'])->name('teacher.detail');
    Route::get('/kalender', [AcademicController::class, 'calendar'])->name('calendar');
    Route::get('/prestasi', [AcademicController::class, 'achievements'])->name('achievements');

    // Detail routes
    Route::get('/guru/{teacher}', [AcademicController::class, 'teacherDetail'])->name('teacher-detail');

    // Download/Export routes
    Route::get('/silabus/{subject}/download', [AcademicController::class, 'downloadSyllabus'])->name('syllabus.download');
    Route::get('/kalender/export', [AcademicController::class, 'exportCalendar'])->name('calendar.export');
});

// Extracurricular Routes
Route::get('/ekstrakurikuler', [\App\Http\Controllers\ExtracurricularController::class, 'index'])->name('extracurriculars.index');
Route::get('/ekstrakurikuler/{extracurricular:slug}', [\App\Http\Controllers\ExtracurricularController::class, 'show'])->name('extracurriculars.show');
Route::get('/ekstrakurikuler/{extracurricular:slug}/register', [\App\Http\Controllers\ExtracurricularController::class, 'showRegistrationForm'])->name('extracurriculars.register.form');
Route::post('/ekstrakurikuler/{extracurricular:slug}/register', [\App\Http\Controllers\ExtracurricularController::class, 'register'])->name('extracurriculars.register');
Route::delete('/ekstrakurikuler/{extracurricular:slug}/cancel', [\App\Http\Controllers\ExtracurricularController::class, 'cancelRegistration'])->name('extracurriculars.cancel');
Route::get('/ekstrakurikuler/filter', [\App\Http\Controllers\ExtracurricularController::class, 'filter'])->name('extracurriculars.filter');

// API Routes for Modal


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
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // User Registrations Management
        Route::get('/user-registrations', [UserRegistrationController::class, 'index'])->name('user-registrations.index');
        Route::get('/user-registrations/{userRegistration}', [UserRegistrationController::class, 'show'])->name('user-registrations.show');
        Route::post('/user-registrations/{userRegistration}/approve', [UserRegistrationController::class, 'approve'])->name('user-registrations.approve');
        Route::post('/user-registrations/{userRegistration}/reject', [UserRegistrationController::class, 'reject'])->name('user-registrations.reject');
        Route::post('/user-registrations/bulk-status', [UserRegistrationController::class, 'bulkStatus'])->name('user-registrations.bulk-status');
        Route::delete('/user-registrations/{userRegistration}', [UserRegistrationController::class, 'destroy'])->name('user-registrations.destroy');
        Route::get('/user-registrations/export', [UserRegistrationController::class, 'export'])->name('user-registrations.export');

        // PPDB Settings Management
        Route::get('/ppdb-settings', [\App\Http\Controllers\Admin\PPDBSettingsController::class, 'index'])->name('ppdb-settings.index');
        Route::put('/ppdb-settings', [\App\Http\Controllers\Admin\PPDBSettingsController::class, 'update'])->name('ppdb-settings.update');
        Route::post('/ppdb-settings/toggle-status', [\App\Http\Controllers\Admin\PPDBSettingsController::class, 'toggleStatus'])->name('ppdb-settings.toggle-status');

        // PPDB Registrations Management
        Route::get('/ppdb-registrations', [\App\Http\Controllers\Admin\PPDBRegistrationController::class, 'index'])->name('ppdb-registrations.index');
        Route::get('/ppdb-registrations/export', [\App\Http\Controllers\Admin\PPDBRegistrationController::class, 'export'])->name('ppdb-registrations.export');
        Route::post('/ppdb-registrations/bulk-status', [\App\Http\Controllers\Admin\PPDBRegistrationController::class, 'bulkStatus'])->name('ppdb-registrations.bulk-status');
        Route::get('/ppdb-registrations/{ppdbRegistration}', [\App\Http\Controllers\Admin\PPDBRegistrationController::class, 'show'])->name('ppdb-registrations.show');
        Route::post('/ppdb-registrations/{ppdbRegistration}/approve', [\App\Http\Controllers\Admin\PPDBRegistrationController::class, 'approve'])->name('ppdb-registrations.approve');
        Route::post('/ppdb-registrations/{ppdbRegistration}/reject', [\App\Http\Controllers\Admin\PPDBRegistrationController::class, 'reject'])->name('ppdb-registrations.reject');
        Route::delete('/ppdb-registrations/{ppdbRegistration}', [\App\Http\Controllers\Admin\PPDBRegistrationController::class, 'destroy'])->name('ppdb-registrations.destroy');

        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/mark-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::delete('/notifications/delete', [\App\Http\Controllers\Admin\NotificationController::class, 'delete'])->name('notifications.delete');
        
        // Notification API
        Route::get('/api/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('api.notifications');
        Route::get('/api/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('api.notifications.unread-count');
        Route::post('/api/notifications/{id}/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('api.notifications.mark-read');
        Route::post('/api/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('api.notifications.mark-all-read');
        Route::get('/api/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('api.notifications.show');
        
        // Messages Management
        Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');

        // Homepage Settings Management
        Route::get('/homepage-settings', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'index'])->name('homepage-settings.index');
        Route::get('/homepage-settings/edit', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'edit'])->name('homepage-settings.edit');
        Route::put('/homepage-settings', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'update'])->name('homepage-settings.update');
        Route::post('/homepage-settings/ajax-update', [\App\Http\Controllers\Admin\HomepageSettingController::class, 'updateAjax'])->name('homepage-settings.ajax-update');

        // About Page Settings Management
        Route::get('/about-page-settings', [\App\Http\Controllers\Admin\AboutPageSettingController::class, 'index'])->name('about-page-settings.index');
        Route::get('/about-page-settings/edit', [\App\Http\Controllers\Admin\AboutPageSettingController::class, 'edit'])->name('about-page-settings.edit');
        Route::put('/about-page-settings', [\App\Http\Controllers\Admin\AboutPageSettingController::class, 'update'])->name('about-page-settings.update');


        // News Management
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
        Route::post('news/{news}/toggle-featured', [\App\Http\Controllers\Admin\NewsController::class, 'toggleFeatured'])->name('news.toggle-featured');
        Route::post('news/bulk-action', [\App\Http\Controllers\Admin\NewsController::class, 'bulkAction'])->name('news.bulk-action');
        Route::post('news/export', [\App\Http\Controllers\Admin\NewsController::class, 'export'])->name('news.export');

        // Test route for debugging
        Route::get('test-delete', function () {
            return response()->json(['message' => 'Test route works']);
        })->name('test.delete');

        // Test delete route
        Route::delete('test-delete/{id}', function ($id) {
            return response()->json(['success' => true, 'message' => 'Test delete works', 'id' => $id]);
        })->name('test.delete.route');

        // Facility Management
        Route::resource('facilities', \App\Http\Controllers\Admin\FacilityController::class)->parameters([
            'facilities' => 'facility'
        ]);
        Route::post('facilities/bulk-delete', [\App\Http\Controllers\Admin\FacilityController::class, 'bulkDelete'])->name('facilities.bulk-delete');
        Route::post('facilities/bulk-status', [\App\Http\Controllers\Admin\FacilityController::class, 'bulkStatus'])->name('facilities.bulk-status');

        // Gallery Management
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class)->parameters([
            'gallery' => 'gallery:id'
        ]);
        Route::post('gallery/bulk-delete', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkDelete'])->name('gallery.bulk-delete');
        Route::post('gallery/bulk-status', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkStatus'])->name('gallery.bulk-status');



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

        // Achievement Management (moved to dashboard)
        Route::get('achievements', [\App\Http\Controllers\Admin\AchievementController::class, 'index'])->name('achievements.index');
        Route::get('achievements/create', [\App\Http\Controllers\Admin\AchievementController::class, 'create'])->name('achievements.create');
        Route::post('achievements', [\App\Http\Controllers\Admin\AchievementController::class, 'store'])->name('achievements.store');
        Route::get('achievements/{achievement}/edit', [\App\Http\Controllers\Admin\AchievementController::class, 'edit'])->name('achievements.edit');
        Route::put('achievements/{achievement}', [\App\Http\Controllers\Admin\AchievementController::class, 'update'])->name('achievements.update');
        Route::delete('achievements/{achievement}', [\App\Http\Controllers\Admin\AchievementController::class, 'destroy'])->name('achievements.destroy');
        Route::post('achievements/{achievement}/toggle-featured', [\App\Http\Controllers\Admin\AchievementController::class, 'toggleFeatured'])->name('achievements.toggle-featured');
        Route::post('achievements/{achievement}/toggle-published', [\App\Http\Controllers\Admin\AchievementController::class, 'togglePublished'])->name('achievements.toggle-published');
        Route::post('achievements/bulk-action', [\App\Http\Controllers\Admin\AchievementController::class, 'bulkAction'])->name('achievements.bulk-action');

        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::post('users/{user}/toggle-active', [\App\Http\Controllers\Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::post('users/bulk-action', [\App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('users.bulk-action');
        Route::get('users/export', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');

        // Export Routes
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('calendar', [\App\Http\Controllers\Admin\ExportController::class, 'exportCalendar'])->name('calendar');
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
        Route::get('/profil/create', [TeacherProfileController::class, 'create'])->name('profile.create');
        Route::post('/profil', [TeacherProfileController::class, 'store'])->name('profile.store');
        Route::get('/profil/edit', [TeacherProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [TeacherProfileController::class, 'update'])->name('profile.update');
        Route::post('/profil/photo', [TeacherProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::put('/profil/password', [TeacherProfileController::class, 'updatePassword'])->name('profile.password');
        Route::get('/profil/portfolio', [TeacherProfileController::class, 'portfolio'])->name('profile.portfolio');
        Route::get('/profil/keamanan', [TeacherProfileController::class, 'security'])->name('profile.security');
        Route::get('/profil/sessions', [TeacherProfileController::class, 'sessions'])->name('profile.sessions');
        Route::post('/profil/logout-devices', [TeacherProfileController::class, 'logoutOtherDevices'])->name('profile.logout-devices');
        Route::put('/profil/privacy', [TeacherProfileController::class, 'updatePrivacy'])->name('profile.privacy');

        // Assignments
        Route::resource('assignments', AssignmentController::class);
        Route::get('/assignments/{assignment}/download', [AssignmentController::class, 'download'])->name('assignments.download');
        Route::post('/assignments/{assignment}/toggle-publish', [AssignmentController::class, 'togglePublish'])->name('assignments.toggle-publish');
        Route::post('/assignments/{assignment}/submissions/{submission}/grade', [AssignmentController::class, 'gradeSubmission'])->name('assignments.grade-submission');

        // Grades
        Route::resource('grades', GradeController::class);
        Route::get('/grades/class/{class}', [GradeController::class, 'showClass'])->name('grades.class');
        Route::get('/grades/analytics', [GradeController::class, 'analytics'])->name('grades.analytics');
        Route::post('/grades/export', [GradeController::class, 'export'])->name('grades.export');

        // Attendance
        Route::resource('attendance', AttendanceController::class);
        Route::get('/attendance/class/{class}/subject/{subject}', [AttendanceController::class, 'showClass'])->name('attendance.class');
        Route::get('/attendance/analytics', [AttendanceController::class, 'analytics'])->name('attendance.analytics');
        Route::post('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');

        // Learning Materials
        Route::resource('learning-materials', LearningMaterialController::class);
        Route::get('/learning-materials/{learningMaterial}/download', [LearningMaterialController::class, 'download'])->name('learning-materials.download');
        Route::post('/learning-materials/{learningMaterial}/toggle-publish', [LearningMaterialController::class, 'togglePublish'])->name('learning-materials.toggle-publish');

        // Schedules
        Route::resource('schedules', TeacherScheduleController::class);
        Route::get('/schedules/calendar', [TeacherScheduleController::class, 'calendar'])->name('schedules.calendar');
        Route::get('/schedules/events', [TeacherScheduleController::class, 'getEvents'])->name('schedules.events');
    });

    // Student Routes
    Route::middleware(['auth', 'student'])->prefix('siswa')->name('student.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
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


require __DIR__ . '/auth.php';

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\Extracurricular;
use App\Models\AcademicYear;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Export academic calendar to PDF
     */
    public function exportCalendar(Request $request)
    {
        $academicYearId = $request->get('academic_year_id');
        $eventType = $request->get('event_type');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = AcademicCalendar::with('academicYear');

        if ($academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        }

        if ($eventType) {
            $query->where('event_type', $eventType);
        }

        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('start_date', '<=', $endDate);
        }

        $events = $query->orderBy('start_date')->get();
        $academicYear = $academicYearId ? 
            AcademicYear::find($academicYearId) : 
            AcademicYear::where('is_active', true)->first();

        $pdf = Pdf::loadView('admin.exports.calendar', compact('events', 'academicYear'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        $filename = 'Kalender_Akademik_' . ($academicYear ? $academicYear->name : 'All') . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Export extracurricular schedule to PDF
     */
    public function exportExtracurricularSchedule(Request $request)
    {
        $category = $request->get('category');
        $day = $request->get('day');

        $query = Extracurricular::with('instructor')
            ->where('is_active', true);

        if ($category) {
            $query->where('category', $category);
        }

        if ($day) {
            $query->where('schedule_day', $day);
        }

        $extracurriculars = $query->orderBy('schedule_day')
            ->orderBy('schedule_time')
            ->get();

        // Group by day
        $scheduleByDay = $extracurriculars->groupBy('schedule_day');

        $pdf = Pdf::loadView('admin.exports.extracurricular-schedule', compact('scheduleByDay', 'category', 'day'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        $filename = 'Jadwal_Ekstrakurikuler_' . ($category ? $category : 'All') . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Export achievements to PDF
     */
    public function exportAchievements(Request $request)
    {
        $category = $request->get('category');
        $year = $request->get('year');
        $level = $request->get('level');

        $query = \App\Models\Achievement::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($year) {
            $query->whereYear('date', $year);
        }

        if ($level) {
            $query->where('achievement_level', $level);
        }

        $achievements = $query->orderBy('date', 'desc')->get();

        // Group by year
        $achievementsByYear = $achievements->groupBy(function ($achievement) {
            return $achievement->date->format('Y');
        });

        $pdf = Pdf::loadView('admin.exports.achievements', compact('achievementsByYear', 'category', 'year', 'level'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        $filename = 'Prestasi_Sekolah_' . ($year ? $year : 'All') . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Export subjects to PDF
     */
    public function exportSubjects(Request $request)
    {
        $gradeLevel = $request->get('grade_level');

        $query = \App\Models\Subject::where('is_active', true);

        if ($gradeLevel) {
            $query->where('grade_level', $gradeLevel);
        }

        $subjects = $query->orderBy('grade_level')
            ->orderBy('name')
            ->get();

        // Group by grade level
        $subjectsByGrade = $subjects->groupBy('grade_level');

        $pdf = Pdf::loadView('admin.exports.subjects', compact('subjectsByGrade', 'gradeLevel'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        $filename = 'Mata_Pelajaran_' . ($gradeLevel ? 'Kelas_' . $gradeLevel : 'All') . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Export school report to PDF
     */
    public function exportSchoolReport()
    {
        $academicYear = AcademicYear::where('is_active', true)->first();
        
        // Get statistics
        $stats = [
            'total_students' => \App\Models\User::where('role', 'student')->count(),
            'total_teachers' => \App\Models\Teacher::count(),
            'total_extracurriculars' => Extracurricular::where('is_active', true)->count(),
            'total_achievements' => \App\Models\Achievement::count(),
            'total_subjects' => \App\Models\Subject::where('is_active', true)->count(),
        ];

        // Get recent achievements
        $recentAchievements = \App\Models\Achievement::orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Get upcoming events
        $upcomingEvents = AcademicCalendar::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(10)
            ->get();

        $pdf = Pdf::loadView('admin.exports.school-report', compact('stats', 'recentAchievements', 'upcomingEvents', 'academicYear'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        $filename = 'Laporan_Sekolah_' . ($academicYear ? $academicYear->name : 'All') . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}


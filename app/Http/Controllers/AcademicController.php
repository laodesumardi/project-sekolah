<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\AcademicCalendar;
use App\Models\Achievement;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    /**
     * Display curriculum page.
     */
    public function curriculum()
    {
        $subjects = Subject::active()->orderBy('grade_level')->orderBy('name')->get();
        $subjectsByGrade = $subjects->groupBy('grade_level');
        
        return view('frontend.academic.curriculum', compact('subjectsByGrade'));
    }



    /**
     * Display teachers page.
     */
    public function teachers(Request $request)
    {
        $query = Teacher::with('user');

        // Filter by subject/department
        if ($request->has('subject') && $request->subject) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }

        $teachers = $query->get()->sortBy(function($teacher) {
            return $teacher->user ? $teacher->user->name : 'Unknown';
        });
        
        // Get subjects for filter
        $subjects = Teacher::select('subject')
            ->whereNotNull('subject')
            ->distinct()
            ->pluck('subject')
            ->filter()
            ->sort()
            ->values();

        return view('frontend.academic.teachers', compact('teachers', 'subjects'));
    }

    /**
     * Display teacher detail.
     */
    public function teacherDetail(Teacher $teacher)
    {
        $teacher->load(['user', 'extracurriculars']);
        
        // Get related teachers (same subject, excluding current)
        $relatedTeachers = Teacher::where('subject', $teacher->subject)
            ->where('id', '!=', $teacher->id)
            ->with('user')
            ->limit(3)
            ->get();
        
        return view('frontend.academic.teacher-detail', compact('teacher', 'relatedTeachers'));
    }

    /**
     * Display academic calendar page.
     */
    public function calendar()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $events = AcademicCalendar::with('academicYear')
            ->where('academic_year_id', $currentYear->id ?? null)
            ->orderBy('start_date')
            ->get();

        return view('frontend.academic.calendar', compact('events', 'currentYear'));
    }

    /**
     * Display achievements page.
     */
    public function achievements(Request $request)
    {
        $query = Achievement::query();

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $achievements = $query->orderBy('date', 'desc')->get();
        
        // Get years and categories for filter
        $years = Achievement::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            
        $categories = Achievement::select('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('frontend.academic.achievements', compact('achievements', 'years', 'categories'));
    }

    /**
     * Download syllabus.
     */
    public function downloadSyllabus(Subject $subject)
    {
        if (!$subject->syllabus_file) {
            abort(404);
        }

        $filePath = storage_path('app/public/syllabi/' . $subject->syllabus_file);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $subject->name . ' - Silabus.pdf');
    }


    /**
     * Export academic calendar.
     */
    public function exportCalendar()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $events = AcademicCalendar::with('academicYear')
            ->where('academic_year_id', $currentYear->id ?? null)
            ->orderBy('start_date')
            ->get();

        return view('frontend.academic.calendar-pdf', compact('events', 'currentYear'));
    }
}
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display the student's schedule.
     */
    public function index(Request $request)
    {
        $student = Auth::user()->profile;
        
        // Get current academic year
        $currentYear = $this->getCurrentAcademicYear();
        
        // Get student's class
        $studentClass = $student->class;
        
        // Get filter parameters
        $selectedDay = $request->get('day', null);
        $selectedSubject = $request->get('subject', null);
        $selectedTeacher = $request->get('teacher', null);
        
        // Get schedule for current week
        $schedule = $this->getWeeklySchedule($studentClass);
        
        // Get today's schedule
        $todaySchedule = $this->getTodaySchedule($studentClass);
        
        // Get schedule statistics
        $stats = $this->getScheduleStats($studentClass);
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($schedule);
        
        // Get upcoming classes (next 3 days)
        $upcomingClasses = $this->getUpcomingClasses($studentClass);
        
        // Get current time info
        $currentTime = $this->getCurrentTimeInfo($todaySchedule);
        
        return view('student.jadwal.index', compact(
            'student',
            'currentYear',
            'studentClass',
            'schedule',
            'todaySchedule',
            'stats',
            'filterOptions',
            'upcomingClasses',
            'currentTime',
            'selectedDay',
            'selectedSubject',
            'selectedTeacher'
        ));
    }
    
    /**
     * Get schedule for a specific date.
     */
    public function show($date)
    {
        $student = Auth::user()->profile;
        $studentClass = $student->class;
        
        $selectedDate = Carbon::parse($date);
        $schedule = $this->getDateSchedule($studentClass, $selectedDate);
        
        return view('student.jadwal.show', compact(
            'student',
            'studentClass',
            'selectedDate',
            'schedule'
        ));
    }
    
    /**
     * Get current academic year.
     */
    private function getCurrentAcademicYear()
    {
        return AcademicYear::where('is_active', true)->first() ?? 
               AcademicYear::latest()->first();
    }
    
    /**
     * Get weekly schedule for a class.
     */
    private function getWeeklySchedule($class)
    {
        // Placeholder - implement with actual schedule data
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $schedule = [];
        
        foreach ($days as $day) {
            $schedule[$day] = [
                [
                    'time' => '07:00-07:45',
                    'subject' => 'Matematika',
                    'teacher' => 'Budi Santoso, S.Pd',
                    'room' => 'A-101',
                    'type' => 'Pelajaran'
                ],
                [
                    'time' => '07:45-08:30',
                    'subject' => 'Bahasa Indonesia',
                    'teacher' => 'Siti Aminah, S.Pd',
                    'room' => 'A-102',
                    'type' => 'Pelajaran'
                ],
                [
                    'time' => '08:45-09:30',
                    'subject' => 'IPA',
                    'teacher' => 'Ahmad Rizki, S.Pd',
                    'room' => 'Lab-1',
                    'type' => 'Praktikum'
                ],
                [
                    'time' => '09:30-10:15',
                    'subject' => 'Bahasa Inggris',
                    'teacher' => 'Sarah Johnson, S.Pd',
                    'room' => 'A-103',
                    'type' => 'Pelajaran'
                ],
                [
                    'time' => '10:30-11:15',
                    'subject' => 'IPS',
                    'teacher' => 'Dewi Kartika, S.Pd',
                    'room' => 'A-104',
                    'type' => 'Pelajaran'
                ],
                [
                    'time' => '11:15-12:00',
                    'subject' => 'Pendidikan Agama',
                    'teacher' => 'Ustadz Ali, S.Ag',
                    'room' => 'A-105',
                    'type' => 'Pelajaran'
                ]
            ];
        }
        
        return $schedule;
    }
    
    /**
     * Get today's schedule.
     */
    private function getTodaySchedule($class)
    {
        $today = Carbon::now();
        $dayName = $today->locale('id')->dayName;
        
        // Map day names
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        
        $indonesianDay = $dayMap[$dayName] ?? 'Senin';
        
        $weeklySchedule = $this->getWeeklySchedule($class);
        return $weeklySchedule[$indonesianDay] ?? [];
    }
    
    /**
     * Get schedule for a specific date.
     */
    private function getDateSchedule($class, $date)
    {
        $dayName = $date->locale('id')->dayName;
        
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        
        $indonesianDay = $dayMap[$dayName] ?? 'Senin';
        
        $weeklySchedule = $this->getWeeklySchedule($class);
        return $weeklySchedule[$indonesianDay] ?? [];
    }
    
    /**
     * Get schedule statistics.
     */
    private function getScheduleStats($class)
    {
        $weeklySchedule = $this->getWeeklySchedule($class);
        $totalSubjects = 0;
        $totalHours = 0;
        $subjectCounts = [];
        $teacherCounts = [];
        
        foreach ($weeklySchedule as $daySchedule) {
            $totalSubjects += count($daySchedule);
            $totalHours += count($daySchedule);
            
            foreach ($daySchedule as $lesson) {
                // Count subjects
                if (!isset($subjectCounts[$lesson['subject']])) {
                    $subjectCounts[$lesson['subject']] = 0;
                }
                $subjectCounts[$lesson['subject']]++;
                
                // Count teachers
                if (!isset($teacherCounts[$lesson['teacher']])) {
                    $teacherCounts[$lesson['teacher']] = 0;
                }
                $teacherCounts[$lesson['teacher']]++;
            }
        }
        
        return [
            'total_subjects' => $totalSubjects,
            'total_hours' => $totalHours,
            'days_with_class' => count(array_filter($weeklySchedule, function($day) {
                return !empty($day);
            })),
            'unique_subjects' => count($subjectCounts),
            'unique_teachers' => count($teacherCounts),
            'subject_breakdown' => $subjectCounts,
            'teacher_breakdown' => $teacherCounts
        ];
    }
    
    /**
     * Get filter options for schedule.
     */
    private function getFilterOptions($schedule)
    {
        $days = array_keys($schedule);
        $subjects = [];
        $teachers = [];
        
        foreach ($schedule as $daySchedule) {
            foreach ($daySchedule as $lesson) {
                if (!in_array($lesson['subject'], $subjects)) {
                    $subjects[] = $lesson['subject'];
                }
                if (!in_array($lesson['teacher'], $teachers)) {
                    $teachers[] = $lesson['teacher'];
                }
            }
        }
        
        return [
            'days' => $days,
            'subjects' => $subjects,
            'teachers' => $teachers
        ];
    }
    
    /**
     * Get upcoming classes for next 3 days.
     */
    private function getUpcomingClasses($class)
    {
        $upcoming = [];
        $today = Carbon::now();
        
        for ($i = 1; $i <= 3; $i++) {
            $date = $today->copy()->addDays($i);
            $dayName = $date->locale('id')->dayName;
            
            $dayMap = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu'
            ];
            
            $indonesianDay = $dayMap[$dayName] ?? 'Senin';
            $weeklySchedule = $this->getWeeklySchedule($class);
            $daySchedule = $weeklySchedule[$indonesianDay] ?? [];
            
            if (!empty($daySchedule)) {
                $upcoming[] = [
                    'date' => $date,
                    'day' => $indonesianDay,
                    'schedule' => $daySchedule,
                    'count' => count($daySchedule)
                ];
            }
        }
        
        return $upcoming;
    }
    
    /**
     * Get current time information.
     */
    private function getCurrentTimeInfo($todaySchedule)
    {
        $now = Carbon::now();
        $currentHour = $now->format('H:i');
        $currentClass = null;
        $nextClass = null;
        $classStatus = 'no_class';
        
        foreach ($todaySchedule as $index => $lesson) {
            $startTime = Carbon::createFromFormat('H:i', explode('-', $lesson['time'])[0]);
            $endTime = Carbon::createFromFormat('H:i', explode('-', $lesson['time'])[1]);
            
            if ($now->between($startTime, $endTime)) {
                $currentClass = $lesson;
                $classStatus = 'in_class';
                break;
            } elseif ($startTime->isFuture()) {
                $nextClass = $lesson;
                $classStatus = 'break';
                break;
            }
        }
        
        return [
            'current_time' => $currentHour,
            'current_class' => $currentClass,
            'next_class' => $nextClass,
            'status' => $classStatus
        ];
    }
    
    /**
     * Export schedule to PDF.
     */
    public function exportPdf()
    {
        $student = Auth::user()->profile;
        $studentClass = $student->class;
        $schedule = $this->getWeeklySchedule($studentClass);
        $stats = $this->getScheduleStats($studentClass);
        
        // Generate PDF (placeholder)
        return response()->json([
            'message' => 'PDF export functionality will be implemented',
            'data' => compact('schedule', 'stats')
        ]);
    }
    
    /**
     * Export schedule to Excel.
     */
    public function exportExcel()
    {
        $student = Auth::user()->profile;
        $studentClass = $student->class;
        $schedule = $this->getWeeklySchedule($studentClass);
        
        // Generate Excel (placeholder)
        return response()->json([
            'message' => 'Excel export functionality will be implemented',
            'data' => compact('schedule')
        ]);
    }
}

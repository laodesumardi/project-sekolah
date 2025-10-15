<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $query = Attendance::where('teacher_id', $teacher->id)
            ->with(['student', 'class', 'subject']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(20);

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.attendance.index', compact('attendances', 'classes', 'subjects'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.attendance.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:profiles,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused,sick',
            'attendances.*.notes' => 'nullable|string|max:500',
        ]);

        $classId = $request->class_id;
        $subjectId = $request->subject_id;
        $date = $request->date;

        // Check if teacher teaches this class and subject
        if (!$teacher->classes->contains($classId) || !$teacher->subjects->contains($subjectId)) {
            return redirect()->back()
                ->with('error', 'Anda tidak mengajar kelas atau mata pelajaran ini.');
        }

        $created = 0;
        $updated = 0;

        foreach ($request->attendances as $attendanceData) {
            $attendance = Attendance::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'student_id' => $attendanceData['student_id'],
                    'class_id' => $classId,
                    'subject_id' => $subjectId,
                    'date' => $date,
                ],
                [
                    'status' => $attendanceData['status'],
                    'notes' => $attendanceData['notes'] ?? null,
                ]
            );

            if ($attendance->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }

        $message = "Absensi berhasil disimpan! ";
        if ($created > 0) {
            $message .= "{$created} data baru ditambahkan. ";
        }
        if ($updated > 0) {
            $message .= "{$updated} data diperbarui.";
        }

        return redirect()->route('teacher.attendance.index')
            ->with('success', $message);
    }

    public function show(Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if attendance belongs to teacher
        if ($attendance->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to attendance.');
        }

        $attendance->load(['student', 'class', 'subject']);

        return view('teacher.attendance.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if attendance belongs to teacher
        if ($attendance->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to attendance.');
        }

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.attendance.edit', compact('attendance', 'classes', 'subjects'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if attendance belongs to teacher
        if ($attendance->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to attendance.');
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused,sick',
            'notes' => 'nullable|string|max:500',
        ]);

        $attendance->update($request->only([
            'class_id', 'subject_id', 'date', 'status', 'notes'
        ]));

        return redirect()->route('teacher.attendance.show', $attendance)
            ->with('success', 'Absensi berhasil diperbarui!');
    }

    public function destroy(Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if attendance belongs to teacher
        if ($attendance->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to attendance.');
        }

        $attendance->delete();

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Absensi berhasil dihapus!');
    }

    public function showClass(SchoolClass $class, Subject $subject, $date = null)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if teacher teaches this class and subject
        if (!$teacher->classes->contains($class) || !$teacher->subjects->contains($subject)) {
            abort(403, 'Unauthorized access to class or subject.');
        }

        $date = $date ? Carbon::parse($date) : Carbon::now();

        $students = $class->students()->with('user')->get();
        
        $attendances = Attendance::where('teacher_id', $teacher->id)
            ->where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.class', compact('class', 'subject', 'date', 'students', 'attendances'));
    }

    public function analytics()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $analytics = [
            'total_attendances' => Attendance::where('teacher_id', $teacher->id)->count(),
            'present_count' => Attendance::where('teacher_id', $teacher->id)->where('status', 'present')->count(),
            'absent_count' => Attendance::where('teacher_id', $teacher->id)->where('status', 'absent')->count(),
            'late_count' => Attendance::where('teacher_id', $teacher->id)->where('status', 'late')->count(),
            'excused_count' => Attendance::where('teacher_id', $teacher->id)->where('status', 'excused')->count(),
            'sick_count' => Attendance::where('teacher_id', $teacher->id)->where('status', 'sick')->count(),
            'attendance_by_class' => Attendance::where('teacher_id', $teacher->id)
                ->join('school_classes', 'attendances.class_id', '=', 'school_classes.id')
                ->selectRaw('school_classes.name, COUNT(*) as count')
                ->groupBy('school_classes.id', 'school_classes.name')
                ->get(),
            'attendance_by_subject' => Attendance::where('teacher_id', $teacher->id)
                ->join('subjects', 'attendances.subject_id', '=', 'subjects.id')
                ->selectRaw('subjects.name, COUNT(*) as count')
                ->groupBy('subjects.id', 'subjects.name')
                ->get(),
        ];

        return view('teacher.attendance.analytics', compact('analytics'));
    }

    public function export(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $query = Attendance::where('teacher_id', $teacher->id)
            ->with(['student', 'class', 'subject']);

        // Apply filters
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        // Generate CSV
        $filename = 'attendance_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Nama Siswa',
                'Kelas',
                'Mata Pelajaran',
                'Tanggal',
                'Status',
                'Catatan'
            ]);

            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->student->name,
                    $attendance->class->name,
                    $attendance->subject->name,
                    $attendance->date->format('d/m/Y'),
                    $attendance->status_name,
                    $attendance->notes
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

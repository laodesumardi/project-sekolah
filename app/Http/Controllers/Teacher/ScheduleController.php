<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $query = $teacher->schedules()->with(['class', 'subject']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by day
        if ($request->filled('day_of_week')) {
            $query->where('day_of_week', $request->day_of_week);
        }

        $schedules = $query->orderBy('day_of_week')->orderBy('start_time')->paginate(20);

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return view('teacher.schedules.index', compact('schedules', 'classes', 'subjects', 'days'));
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

        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return view('teacher.schedules.create', compact('classes', 'subjects', 'days'));
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
            'day_of_week' => 'required|integer|min:1|max:7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
        ]);

        $data = $request->only([
            'class_id', 'subject_id', 'day_of_week', 
            'start_time', 'end_time', 'room'
        ]);

        $data['teacher_id'] = $teacher->id;

        // Check for time conflicts
        $conflict = Schedule::where('teacher_id', $teacher->id)
            ->where('day_of_week', $data['day_of_week'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                      ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                      ->orWhere(function ($q) use ($data) {
                          $q->where('start_time', '<=', $data['start_time'])
                            ->where('end_time', '>=', $data['end_time']);
                      });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada.')
                ->withInput();
        }

        Schedule::create($data);

        return redirect()->route('teacher.schedules.index')
            ->with('success', 'Jadwal berhasil dibuat!');
    }

    public function show(Schedule $schedule)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if schedule belongs to teacher
        if ($schedule->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to schedule.');
        }

        $schedule->load(['class', 'subject']);

        return view('teacher.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if schedule belongs to teacher
        if ($schedule->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to schedule.');
        }

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return view('teacher.schedules.edit', compact('schedule', 'classes', 'subjects', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if schedule belongs to teacher
        if ($schedule->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to schedule.');
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|integer|min:1|max:7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
        ]);

        $data = $request->only([
            'class_id', 'subject_id', 'day_of_week', 
            'start_time', 'end_time', 'room'
        ]);

        // Check for time conflicts (excluding current schedule)
        $conflict = Schedule::where('teacher_id', $teacher->id)
            ->where('id', '!=', $schedule->id)
            ->where('day_of_week', $data['day_of_week'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                      ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                      ->orWhere(function ($q) use ($data) {
                          $q->where('start_time', '<=', $data['start_time'])
                            ->where('end_time', '>=', $data['end_time']);
                      });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada.')
                ->withInput();
        }

        $schedule->update($data);

        return redirect()->route('teacher.schedules.show', $schedule)
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if schedule belongs to teacher
        if ($schedule->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to schedule.');
        }

        $schedule->delete();

        return redirect()->route('teacher.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    public function calendar()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $schedules = $teacher->schedules()
            ->with(['class', 'subject'])
            ->get();

        $events = [];
        foreach ($schedules as $schedule) {
            $events[] = [
                'id' => $schedule->id,
                'title' => $schedule->subject->name . ' - ' . $schedule->class->name,
                'start' => $schedule->start_time->format('H:i'),
                'end' => $schedule->end_time->format('H:i'),
                'day' => $schedule->day_of_week,
                'room' => $schedule->room,
                'color' => $this->getScheduleColor($schedule->subject->name),
            ];
        }

        return view('teacher.schedules.calendar', compact('events'));
    }

    public function getEvents()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        $schedules = $teacher->schedules()
            ->with(['class', 'subject'])
            ->get();

        $events = [];
        foreach ($schedules as $schedule) {
            $events[] = [
                'id' => $schedule->id,
                'title' => $schedule->subject->name . ' - ' . $schedule->class->name,
                'start' => $schedule->start_time->format('H:i'),
                'end' => $schedule->end_time->format('H:i'),
                'day' => $schedule->day_of_week,
                'room' => $schedule->room,
                'color' => $this->getScheduleColor($schedule->subject->name),
            ];
        }

        return response()->json($events);
    }

    private function getScheduleColor($subjectName)
    {
        $colors = [
            'Matematika' => '#e74c3c',
            'Bahasa Indonesia' => '#3498db',
            'Bahasa Inggris' => '#2ecc71',
            'IPA' => '#f39c12',
            'IPS' => '#9b59b6',
            'PKN' => '#1abc9c',
            'Agama' => '#34495e',
            'Olahraga' => '#e67e22',
            'Seni' => '#8e44ad',
        ];

        return $colors[$subjectName] ?? '#95a5a6';
    }
}

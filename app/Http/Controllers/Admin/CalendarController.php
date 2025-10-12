<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $query = AcademicCalendar::with('academicYear');

        // Filter by event type
        if ($request->has('event_type') && $request->event_type) {
            $query->byType($request->event_type);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->where('start_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->where('start_date', '<=', $request->end_date);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('start_date', 'desc')->paginate(15);
        
        // Get event types for filter
        $eventTypes = [
            'exam' => 'Ujian',
            'activity' => 'Kegiatan',
            'holiday' => 'Libur',
            'deadline' => 'Deadline'
        ];

        return view('admin.calendar.index', compact('events', 'eventTypes', 'currentYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $eventTypes = [
            'exam' => 'Ujian',
            'activity' => 'Kegiatan',
            'holiday' => 'Libur',
            'deadline' => 'Deadline'
        ];
        return view('admin.calendar.create', compact('eventTypes', 'currentYear'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:exam,activity,holiday,deadline',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_all_day' => 'boolean',
        ]);

        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $data = $request->all();
        $data['academic_year_id'] = $currentYear->id;
        $data['is_all_day'] = $request->has('is_all_day');
        
        // Set default color based on event type
        if (!$request->color) {
            $colors = [
                'exam' => '#DC2626',      // Red
                'activity' => '#2563EB',  // Blue
                'holiday' => '#16A34A',   // Green
                'deadline' => '#D97706',  // Yellow
            ];
            $data['color'] = $colors[$request->event_type] ?? '#3B82F6';
        }

        AcademicCalendar::create($data);

        return redirect()->route('admin.calendar.index')
            ->with('success', 'Event kalender berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicCalendar $calendar)
    {
        return view('admin.calendar.show', compact('calendar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicCalendar $calendar)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $eventTypes = [
            'exam' => 'Ujian',
            'activity' => 'Kegiatan',
            'holiday' => 'Libur',
            'deadline' => 'Deadline'
        ];
        return view('admin.calendar.edit', compact('calendar', 'eventTypes', 'currentYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicCalendar $calendar)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:exam,activity,holiday,deadline',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_all_day' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_all_day'] = $request->has('is_all_day');
        
        // Set default color based on event type if not provided
        if (!$request->color) {
            $colors = [
                'exam' => '#DC2626',      // Red
                'activity' => '#2563EB',  // Blue
                'holiday' => '#16A34A',   // Green
                'deadline' => '#D97706',  // Yellow
            ];
            $data['color'] = $colors[$request->event_type] ?? '#3B82F6';
        }

        $calendar->update($data);

        return redirect()->route('admin.calendar.index')
            ->with('success', 'Event kalender berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicCalendar $calendar)
    {
        $calendar->delete();

        return redirect()->route('admin.calendar.index')
            ->with('success', 'Event kalender berhasil dihapus.');
    }

    /**
     * Get events for FullCalendar (AJAX).
     */
    public function getEvents(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $events = AcademicCalendar::where('academic_year_id', $currentYear->id ?? null)
            ->where(function($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                      ->orWhereBetween('end_date', [$start, $end])
                      ->orWhere(function($q) use ($start, $end) {
                          $q->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                      });
            })
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->format('Y-m-d'),
                    'end' => $event->end_date ? $event->end_date->format('Y-m-d') : null,
                    'allDay' => $event->is_all_day,
                    'color' => $event->color,
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'description' => $event->description,
                        'event_type' => $event->event_type,
                        'location' => $event->location,
                        'formatted_type' => $event->formatted_event_type,
                    ]
                ];
            });

        return response()->json($events);
    }

    /**
     * Create event via AJAX (for FullCalendar).
     */
    public function createEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:exam,activity,holiday,deadline',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_all_day' => 'boolean',
        ]);

        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $data = $request->all();
        $data['academic_year_id'] = $currentYear->id;
        $data['is_all_day'] = $request->has('is_all_day');
        
        // Set default color based on event type
        if (!$request->color) {
            $colors = [
                'exam' => '#DC2626',      // Red
                'activity' => '#2563EB',  // Blue
                'holiday' => '#16A34A',   // Green
                'deadline' => '#D97706',  // Yellow
            ];
            $data['color'] = $colors[$request->event_type] ?? '#3B82F6';
        }

        $event = AcademicCalendar::create($data);

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    /**
     * Update event via AJAX (for FullCalendar).
     */
    public function updateEvent(Request $request, AcademicCalendar $calendar)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:exam,activity,holiday,deadline',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_all_day' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_all_day'] = $request->has('is_all_day');
        
        // Set default color based on event type if not provided
        if (!$request->color) {
            $colors = [
                'exam' => '#DC2626',      // Red
                'activity' => '#2563EB',  // Blue
                'holiday' => '#16A34A',   // Green
                'deadline' => '#D97706',  // Yellow
            ];
            $data['color'] = $colors[$request->event_type] ?? '#3B82F6';
        }

        $calendar->update($data);

        return response()->json([
            'success' => true,
            'event' => $calendar
        ]);
    }

    /**
     * Delete event via AJAX (for FullCalendar).
     */
    public function deleteEvent(AcademicCalendar $calendar)
    {
        $calendar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    /**
     * Export calendar to PDF.
     */
    public function exportPdf()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $events = AcademicCalendar::where('academic_year_id', $currentYear->id ?? null)
            ->orderBy('start_date')
            ->get();

        return view('admin.calendar.export-pdf', compact('events', 'currentYear'));
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,change_type',
            'event_ids' => 'required|array',
            'event_ids.*' => 'exists:academic_calendar,id',
            'event_type' => 'nullable|in:exam,activity,holiday,deadline',
        ]);

        $eventIds = $request->event_ids;

        switch ($request->action) {
            case 'delete':
                AcademicCalendar::whereIn('id', $eventIds)->delete();
                $message = 'Event kalender berhasil dihapus.';
                break;
            case 'change_type':
                if (!$request->event_type) {
                    return redirect()->back()->withErrors(['event_type' => 'Tipe event harus dipilih untuk aksi ini.']);
                }
                AcademicCalendar::whereIn('id', $eventIds)->update(['event_type' => $request->event_type]);
                $message = 'Tipe event berhasil diubah.';
                break;
        }

        return redirect()->route('admin.calendar.index')->with('success', $message);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Get calendar events for FullCalendar.
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
     * Create new calendar event (admin only).
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
        
        $event = AcademicCalendar::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_type' => $request->event_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'color' => $request->color ?? $this->getDefaultColor($request->event_type),
            'academic_year_id' => $currentYear->id,
            'is_all_day' => $request->is_all_day ?? true,
        ]);

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    /**
     * Update calendar event (admin only).
     */
    public function update(Request $request, AcademicCalendar $event)
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

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'event_type' => $request->event_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'color' => $request->color ?? $this->getDefaultColor($request->event_type),
            'is_all_day' => $request->is_all_day ?? true,
        ]);

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    /**
     * Delete calendar event (admin only).
     */
    public function destroy(AcademicCalendar $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    /**
     * Get event details.
     */
    public function show(AcademicCalendar $event)
    {
        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'event_type' => $event->event_type,
            'formatted_type' => $event->formatted_event_type,
            'start_date' => $event->start_date->format('Y-m-d'),
            'end_date' => $event->end_date ? $event->end_date->format('Y-m-d') : null,
            'start_time' => $event->start_time ? $event->start_time->format('H:i') : null,
            'end_time' => $event->end_time ? $event->end_time->format('H:i') : null,
            'location' => $event->location,
            'color' => $event->color,
            'is_all_day' => $event->is_all_day,
            'duration' => $event->duration,
        ]);
    }

    /**
     * Get default color for event type.
     */
    private function getDefaultColor($eventType)
    {
        $colors = [
            'exam' => '#DC2626',      // Red
            'activity' => '#2563EB',  // Blue
            'holiday' => '#16A34A',   // Green
            'deadline' => '#D97706',  // Yellow
        ];

        return $colors[$eventType] ?? '#3B82F6';
    }
}
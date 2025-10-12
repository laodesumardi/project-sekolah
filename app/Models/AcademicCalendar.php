<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AcademicCalendar extends Model
{
    protected $table = 'academic_calendar';

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'color',
        'academic_year_id',
        'is_all_day',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'is_all_day' => 'boolean',
        ];
    }

    /**
     * Get the academic year that owns the calendar event.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString());
    }

    /**
     * Scope a query to filter by month.
     */
    public function scopeByMonth($query, $year, $month)
    {
        return $query->whereYear('start_date', $year)
                  ->whereMonth('start_date', $month);
    }

    /**
     * Scope a query to filter by event type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
    }

    /**
     * Get formatted event type.
     */
    public function getFormattedEventTypeAttribute()
    {
        $types = [
            'exam' => 'Ujian',
            'activity' => 'Kegiatan',
            'holiday' => 'Libur',
            'deadline' => 'Deadline'
        ];

        return $types[$this->event_type] ?? ucfirst($this->event_type);
    }

    /**
     * Get event duration in days.
     */
    public function getDurationAttribute()
    {
        if ($this->end_date) {
            return Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;
        }
        return 1;
    }

    /**
     * Check if event is today.
     */
    public function getIsTodayAttribute()
    {
        return $this->start_date->isToday();
    }

    /**
     * Check if event is upcoming.
     */
    public function getIsUpcomingAttribute()
    {
        return $this->start_date->isFuture();
    }
}
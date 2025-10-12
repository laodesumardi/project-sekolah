<?php

namespace App\View\Components;

use App\Models\AcademicCalendar;
use Illuminate\View\Component;

class CalendarEvent extends Component
{
    public $event;
    public $showDescription;
    public $showLocation;
    public $showTime;
    public $showType;
    public $size;
    public $clickable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        AcademicCalendar $event,
        bool $showDescription = true,
        bool $showLocation = true,
        bool $showTime = true,
        bool $showType = true,
        string $size = 'default',
        bool $clickable = true
    ) {
        $this->event = $event;
        $this->showDescription = $showDescription;
        $this->showLocation = $showLocation;
        $this->showTime = $showTime;
        $this->showType = $showType;
        $this->size = $size;
        $this->clickable = $clickable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.calendar-event');
    }
}


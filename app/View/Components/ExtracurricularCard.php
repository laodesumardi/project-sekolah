<?php

namespace App\View\Components;

use App\Models\Extracurricular;
use Illuminate\View\Component;

class ExtracurricularCard extends Component
{
    public $extracurricular;
    public $showCategory;
    public $showSchedule;
    public $showInstructor;
    public $showParticipants;
    public $showDescription;
    public $showImages;
    public $size;
    public $clickable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Extracurricular $extracurricular,
        bool $showCategory = true,
        bool $showSchedule = true,
        bool $showInstructor = true,
        bool $showParticipants = true,
        bool $showDescription = true,
        bool $showImages = false,
        string $size = 'default',
        bool $clickable = true
    ) {
        $this->extracurricular = $extracurricular;
        $this->showCategory = $showCategory;
        $this->showSchedule = $showSchedule;
        $this->showInstructor = $showInstructor;
        $this->showParticipants = $showParticipants;
        $this->showDescription = $showDescription;
        $this->showImages = $showImages;
        $this->size = $size;
        $this->clickable = $clickable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.extracurricular-card');
    }
}


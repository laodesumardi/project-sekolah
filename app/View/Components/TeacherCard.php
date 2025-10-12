<?php

namespace App\View\Components;

use App\Models\Teacher;
use Illuminate\View\Component;

class TeacherCard extends Component
{
    public $teacher;
    public $showSubject;
    public $showEducation;
    public $showExperience;
    public $showContact;
    public $showExtracurriculars;
    public $size;
    public $clickable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Teacher $teacher,
        bool $showSubject = true,
        bool $showEducation = true,
        bool $showExperience = true,
        bool $showContact = false,
        bool $showExtracurriculars = false,
        string $size = 'default',
        bool $clickable = true
    ) {
        $this->teacher = $teacher;
        $this->showSubject = $showSubject;
        $this->showEducation = $showEducation;
        $this->showExperience = $showExperience;
        $this->showContact = $showContact;
        $this->showExtracurriculars = $showExtracurriculars;
        $this->size = $size;
        $this->clickable = $clickable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.teacher-card');
    }
}


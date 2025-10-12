<?php

namespace App\View\Components;

use App\Models\Achievement;
use Illuminate\View\Component;

class AchievementCard extends Component
{
    public $achievement;
    public $showCategory;
    public $showDate;
    public $showDescription;
    public $showParticipants;
    public $showLevel;
    public $size;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Achievement $achievement,
        bool $showCategory = true,
        bool $showDate = true,
        bool $showDescription = true,
        bool $showParticipants = true,
        bool $showLevel = true,
        string $size = 'default'
    ) {
        $this->achievement = $achievement;
        $this->showCategory = $showCategory;
        $this->showDate = $showDate;
        $this->showDescription = $showDescription;
        $this->showParticipants = $showParticipants;
        $this->showLevel = $showLevel;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.achievement-card');
    }
}


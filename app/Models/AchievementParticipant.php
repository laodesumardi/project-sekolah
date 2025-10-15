<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'achievement_id',
        'student_id',
        'participant_name',
        'role',
        'class_name'
    ];

    // Relationships
    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function student()
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->student ? $this->student->name : $this->participant_name;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'achievement_id',
        'teacher_id',
        'role'
    ];

    // Relationships
    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
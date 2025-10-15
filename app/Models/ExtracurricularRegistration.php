<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExtracurricularRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'extracurricular_id', 'student_id', 'registration_date', 'status',
        'reason', 'approved_by', 'approved_at', 'notes'
    ];

    protected $casts = [
        'registration_date' => 'datetime',
        'approved_at' => 'datetime'
    ];

    // Relationships
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    public function student()
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}

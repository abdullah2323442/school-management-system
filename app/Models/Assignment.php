<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject_id',
        'class_id',
        'section_id',
        'teacher_id',
        'file_path',
        'due_date'
    ];

    // Option 1: Using $dates property
    protected $dates = ['due_date'];

    // Option 2: Using $casts property
    protected $casts = [
        'due_date' => 'datetime',
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id')->where('role', User::ROLE_TEACHER);
    }

    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}

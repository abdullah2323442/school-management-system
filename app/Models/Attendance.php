<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'class_id',
        'section_id',
        'date',
        'status',
    ];

    // Option 1: Using $dates property
    protected $dates = ['date'];

    // Option 2: Using a mutator
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ?: now()->format('Y-m-d');
    }


    public function user()
    {
        return $this->belongsTo(User::class)->where('role', User::ROLE_STUDENT);
    }

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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'teacher_id', 'class_id', 'section_id'];



    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    //     public function teacher()
// {
//     return $this->belongsTo(User::class, 'teacher_id')->whereHas('role', function ($query) {
//         $query->where('role', User::ROLE_TEACHER);
//     });
// }

    public function teacher()
    {
        return $this->belongsTo(User::class)->where('role', User::ROLE_TEACHER);
    }



    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'subject_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    



}

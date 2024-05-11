<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'name',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function students()
    {
        return $this->hasMany(User::class, 'class_id')->where('role', User::ROLE_STUDENT);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'section_id');
    }

}

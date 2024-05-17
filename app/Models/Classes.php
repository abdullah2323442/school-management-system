<?php

namespace App\Models;

// use\App\Models\Section;
// use\App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'class_id')->where('role', User::ROLE_STUDENT);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }


}

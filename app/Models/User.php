<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_TEACHER = 'TEACHER';
    const ROLE_STUDENT = 'STUDENT';
    const ROLE_PARENT = 'PARENT';
    const ROLE_DEFAULT = self::ROLE_STUDENT;

    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_TEACHER => 'Teacher',
        self::ROLE_STUDENT => 'Student',
        self::ROLE_PARENT => 'Parent',
    ];



    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTeacher()
    {
        return $this->role === self::ROLE_TEACHER;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_STUDENT;
    }
    public function isParent()
    {
        return $this->role === self::ROLE_PARENT;
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'gender',
        'role',
        'blood',
        'phone_number',
        'address',
        'class_id',
        'section_id',
        'date_of_birth',
        'parent_name',
        'parent_phone_number',
        'parent_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    // app/Models/User.php

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }



    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    public function submissions()
{
    return $this->hasMany(Submission::class);
}


    // app/Models/User.php

    // public function submissions()
    // {
    //     return $this->hasMany(Submission::class);
    // }


}

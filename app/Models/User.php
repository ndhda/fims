<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_management';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'email',
        'password',
        'loa_code',
        'role_id',
        'student_id',
        'staff_id',
        'super_admin_id',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationship with Role model
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    // Relationship with SuperAdmin
    public function superAdmin()
    {
        return $this->hasOne(SuperAdmin::class, 'super_admin_id', 'super_admin_id');
    }

    // Relationship with Staff (Admin)
    public function admin()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'staff_id');
    }

    // Relationship with Student
    public function student()
    {
        return $this->hasOne(Student::class, 'student_id', 'student_id');
    }
}

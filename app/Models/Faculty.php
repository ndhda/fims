<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    protected $primaryKey = 'faculty_id';

    public $timestamps = false;

    protected $fillable = [
        'faculty_name',
        'faculty_code',
    ];

    public function programme()
    {
        return $this->hasMany(Programme::class, 'faculty_id', 'faculty_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class, 'faculty_id');
    }
}

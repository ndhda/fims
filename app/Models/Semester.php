<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semesters';

    protected $primaryKey = 'semester_id';

    protected $fillable = ['semester_name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

}

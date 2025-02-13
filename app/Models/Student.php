<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';

    protected $fillable = [
      'matric_num',
      'full_name',
      'current_year',
      'semester_id',
      'faculty_id',
      'programme_id',
      'status',
      'hostel',
      'international',
      'scholarship',
      'funding_id',
      'email',
      'contact_num',
    ];

    // Define relationships
    public function fees()
    {
        return $this->hasMany(Fee::class, 'student_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function clearanceForms()
    {
        return $this->hasMany(ClearanceForm::class, 'student_id');
    }

    public function fundingSource()
    {
        return $this->belongsTo(FundingSource::class, 'funding_id');
    }

}

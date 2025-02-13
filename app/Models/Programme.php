<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    // Define the table name (optional if it's the plural of the model name)
    protected $table = 'programmes';

    // Define the primary key (optional if it's 'id')
    protected $primaryKey = 'id';

    public $timestamps = true;

    // Set the fields that can be mass-assigned
    protected $fillable = [
      'programme_name',
      'faculty_id',
      'programme_code',
      'programme_duration',
      'level_id',
      'edu_mode_id',
      'edu_type_id',
    ];

    // Set the fields that should not be mass-assigned
    protected $guarded = [];

    // Define relationships with other models

    /**
     * A programme belongs to a faculty
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    /**
     * A programme belongs to a level
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class,  'programme_id');
    }

    public function eduMode()
    {
        return $this->belongsTo(EduMode::class, 'edu_mode_id');
    }

    public function eduType()
    {
        return $this->belongsTo(EduType::class, 'edu_type_id');
    }
}

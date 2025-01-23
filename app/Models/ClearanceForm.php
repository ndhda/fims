<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceForm extends Model
{
    use HasFactory;

    protected $table = 'clearance_form';

    protected $primaryKey = 'clearance_form_id';

    protected $fillable = [
        'clearance_form_id',
        'clearance_form_doc',
        'student_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

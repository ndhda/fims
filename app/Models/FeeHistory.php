<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'fee_category_id', 'academic_session_id', 'amount',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

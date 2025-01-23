<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Fee extends Model
{
    use HasFactory;

    protected $table = 'fee';
    protected $primaryKey = 'fee_id';
    public $timestamps = true;

    protected $fillable = [
        'invoice_num',
        'fee_category_id',
        'description',
        'total_amount',
        'due_date',
        'amount_balance',
        'fee_status_id',
        'year_id',
        'student_id',
        'session_id'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Relationship with FeeStatus model
    public function feeStatus()
    {
        return $this->belongsTo(FeeStatus::class, 'fee_status_id', 'fee_status_id');
    }

    // Relationship with AmountPaid model
    public function amountPaid()
    {
        return $this->hasMany(AmountPaid::class, 'fee_id', 'fee_id');
    }

    // Relationship with FeeCategory model
    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id', 'fee_category_id');
    }

    // Relationship with Year model
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id', 'year_id');
    }

    // Relationship with Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Relationship with AcademicSession model
    public function academicSession()
    {
      return $this->belongsTo(AcademicSession::class, 'session_id', 'session_id');
    }

}

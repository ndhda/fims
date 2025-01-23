<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'fee_rules';
    protected $primaryKey = 'rule_id';

    protected $fillable = [
      'fee_category_id',
      'programme_id',
      'semester_id',
      'hostel',
      'international',
      'scholarship',
      'amount',
  ];

    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}

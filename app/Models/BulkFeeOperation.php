<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkFeeOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'batch_id',
        'total_students',
        'total_fees',
        'status',
        'created_at',
    ];

    public function admin()
    {
        return $this->belongsTo(Staff::class, 'admin_id');
    }
}

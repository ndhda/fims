<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStatus extends Model
{
    use HasFactory;

    protected $table = 'fee_status';
    protected $primaryKey = 'fee_status_id';
    public $timestamps = false;

    protected $fillable = [
        'fee_status_name',
    ];

    // Relationship with Fee model
    public function fees()
    {
        return $this->hasMany(Fee::class, 'fee_status_id', 'fee_status_id');
    }
}

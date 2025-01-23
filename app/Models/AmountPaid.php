<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountPaid extends Model
{
    use HasFactory;

    protected $table = 'paid';
    protected $primaryKey = 'amount_paid_id';
    public $timestamps = false;

    protected $fillable = [
        'amount_paid',
        'fee_id',
        'date_paid',
        'payment_method',
        'payment_proof',
        'reference_num',
        'receipt_num',
    ];

    protected $casts = [
        'date_paid' => 'datetime',
    ];

    // Relationship with Fee model
    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id', 'fee_id');
    }

    public static function boot()
    {
        parent::boot();

        // Automatically generate receipt number when creating a payment
        static::creating(function ($payment) {
            if (!$payment->receipt_num) {
                $payment->receipt_num = 'RCP-' . strtoupper(uniqid());
            }
        });
    }

}

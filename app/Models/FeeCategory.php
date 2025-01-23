<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
    use HasFactory;

    protected $table = 'fee_category';
    protected $primaryKey = 'fee_category_id';
    public $timestamps = false;

    protected $fillable = [
        'fee_category_name',
        'fee_category_code',
    ];

    public function fees()
    {
        return $this->hasMany(Fee::class, 'fee_category_id', 'fee_category_id');
    }

    public function feeRules()
    {
        return $this->hasMany(FeeRule::class, 'fee_category_id', 'fee_category_id');
    }
}

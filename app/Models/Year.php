<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $table = 'year';
    protected $primaryKey = 'year_id';
    public $timestamps = false;

    protected $fillable = [
        'year_name',
    ];

    // Relationship with Fee model
    public function fees()
    {
        return $this->hasMany(Fee::class, 'year_id');
    }
}

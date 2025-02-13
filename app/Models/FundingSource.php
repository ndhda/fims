<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundingSource extends Model
{
    use HasFactory;

    protected $table = 'funding_sources';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'funding_name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'funding_id');
    }
}

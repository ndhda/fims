<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'edu_level';

    protected $primaryKey = 'level_id';

    public $timestamps = true;

    protected $fillable = [
        'level_name',
    ];

    public function programme()
    {
        return $this->hasMany(Programme::class, 'level_id', 'level_id');
    }
}

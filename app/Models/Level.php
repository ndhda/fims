<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'edu_level';

    protected $primaryKey = 'level_id';

    public $timestamps = false;

    protected $fillable = [
        'level_code',
        'level_name',
        'level_duration',
        'study_mode',
    ];

    public function programme()
    {
        return $this->hasMany(Programme::class, 'level_id', 'level_id');
    }
}

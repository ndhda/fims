<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduMode extends Model
{
    use HasFactory;

    protected $table = 'edu_modes';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'study_mode',
    ];

    public function programmes()
    {
        return $this->hasMany(Programme::class,'edu_mode_id');
    }
}

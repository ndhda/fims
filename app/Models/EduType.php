<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduType extends Model
{
    use HasFactory;

    protected $table = 'edu_type';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'edu_type_name',
    ];

    public function programmes()
    {
        return $this->hasMany(Programme::class, 'id');
    }
}

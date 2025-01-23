<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory;

    protected $table = 'academic_session';
    protected $primaryKey = 'session_id';
    public $timestamps = false;

    protected $fillable = [
        'session_name',
        'session_code',
    ];

    // Relationship with Fee model (if applicable)
    public function fees()
    {
        return $this->hasMany(Fee::class, 'session_id');
    }

}

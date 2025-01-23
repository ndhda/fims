<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staffs'; // Ensure the table name is correct
    protected $fillable = ['staff_id', 'staff_name', 'position', 'email'];

    // Define the inverse relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'staff_id');
    }
}

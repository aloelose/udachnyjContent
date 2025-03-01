<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'user_id', 
        'full_name',
        'age',
        'gender',
        'status',
        'pmpk_code',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);  // Связь с родителем
    }
}

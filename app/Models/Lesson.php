<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'content', 'available_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
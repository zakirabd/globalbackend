<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherEnroll extends Model
{
    use HasFactory;

    protected $table = 'teacher_enroll';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'lesson_mode',
        'lesson_hour',
        'status'
    ];

    public function teacher(){
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\User', 'student_id');
    }
}

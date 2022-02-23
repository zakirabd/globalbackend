<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'date',
        'url',
        'time',
        'status'
    ];

    public function teacher(){
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\User', 'student_id');
    }
}

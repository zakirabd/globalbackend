<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExams extends Model
{
    use HasFactory;

    protected $table = 'student_exams';

    protected $fillable = [
        'student_id',
        'exam_id',
        'over_all',
        'point',
        'submit',
        'status'
    ];

    public function exam(){
        return $this->belongsTo('App\Models\Exams', 'exam_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\Users', 'student_id');
    }
}

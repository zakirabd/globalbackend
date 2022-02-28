<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamAnswers extends Model
{
    use HasFactory;

    protected $table = 'student_exam_answers';

    protected $fillable = [
        'student_id',
        'exam_answer_id',
        'is_correct',
        'status',
        'point',
        'correct_answer_id'
    ];

    public function exam_answer(){
        return $this->belongsTo('App\Models\ExamAnswers', 'exam_answer_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\Users', 'student_id');
    }
}

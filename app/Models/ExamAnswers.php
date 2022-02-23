<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswers extends Model
{
    use HasFactory;

    protected $table = 'exam_answers';

    protected $fillable = [
        'exam_child_question_id',
        'title',
        'image',
        'is_correct',
        'status',
        'point'
    ];

    // public function exam_child_question(){
    //     return $this->hasMany('App\Models\ExamChildQuestions');
    // }

}

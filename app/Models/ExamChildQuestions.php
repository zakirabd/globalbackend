<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamChildQuestions extends Model
{
    use HasFactory;

    protected $table = 'exam_child_questions';

    protected $fillable = [
        'exam_parent_question_id',
        'title',
        'description',
        'image',
        'audio',
        'video',
        'video_url',
        'type',
        'status'
    ];
    protected $appends = ['given_answer'];

    public function exam_parent_question(){
        return $this->belongsToMany('App\Models\ExamParentQuestions', 'exam_parent_question_id');
    }

    public function exam_answer(){
        return $this->hasMany('App\Models\ExamAnswers', 'exam_child_question_id');
    }

    public function getGivenAnswerAttribute(){
        return '';
    }
}

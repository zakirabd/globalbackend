<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamParentQuestions extends Model
{
    use HasFactory;

    protected $table = 'exam_parent_questions';

    protected $fillable = [
        'exam_id',
        'title',
        'description',
        'image',
        'audio',
        'video',
        'video_url',
        'type',
        'status'
    ];

    public function exam(){
        return $this->belongsTo('App\Models\Exams', 'exam_id');
    }

    public function exam_child_question(){
        return $this->hasMany('App\Models\ExamChildQuestions', 'exam_parent_question_id')->with('exam_answer');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = [
        'title',
        'point',
        'status'
    ];

    public function exam_parent_question(){
        return $this->hasMany('App\Models\ExamParentQuestions', 'exam_id')->with('exam_child_question');
    }

}

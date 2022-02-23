<?php

namespace App\Http\Controllers;

use App\Models\ExamAnswers;
use App\Models\ExamChildQuestions;
use Illuminate\Http\Request;

class ExamChildQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->role_id == '1' || auth()->user()->role_id == '2'){
            $exams = new ExamChildQuestions();
            $exams->fill($request->all())->save();

            $exam_answers = json_decode($request->exam_answers, true);

            if(isset($exam_answers) && $exam_answers != ''){
                foreach($exam_answers as $answer){
                    if($answer['status'] != '0'){
                        if($answer['id'] != ''){
                            $new_answer = ExamAnswers::findOrFail($answer['id']);
                            $new_answer->title = $answer['title'];
                            $new_answer->is_correct = $answer['is_correct'];
                            $new_answer->point = $answer['point'];
                            $new_answer->status = '1';
                            $new_answer->exam_child_question_id = $exams->id;
                            $new_answer->save();

                        }else if($answer['id'] == ''){
                            $new_answer = new ExamAnswers();
                            $new_answer->title = $answer['title'];
                            $new_answer->is_correct = $answer['is_correct'];
                            $new_answer->point = $answer['point'];
                            $new_answer->status = '1';
                            $new_answer->exam_child_question_id = $exams->id;
                            $new_answer->save();
                        }
                    }else if($answer['status'] == '0'){
                        if($answer['id'] != ''){
                            $new_answer = ExamAnswers::findOrFail($answer['id']);
                            $new_answer->delete();

                        }
                    }
                }
            }


            return response()->json(['msg' => 'Exam child question created successfully.']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $exams = ExamChildQuestions::findOrFail($id);
       $exams->exam_answers = ExamAnswers::where('exam_child_question_id', $id)->orderBy('id', 'ASC')->get();
       return $exams;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->role_id == '1' || auth()->user()->role_id == '2'){
            $exams = ExamChildQuestions::findOrFail($id);
            $exams->fill($request->all())->save();

            $exam_answers = json_decode($request->exam_answers, true);

            if(isset($exam_answers) && $exam_answers != ''){
                foreach($exam_answers as $answer){
                    if($answer['status'] != '0'){
                        if($answer['id'] != ''){
                            $new_answer = ExamAnswers::findOrFail($answer['id']);
                            $new_answer->title = $answer['title'];
                            $new_answer->is_correct = $answer['is_correct'];
                            $new_answer->point = $answer['point'];
                            $new_answer->status = '1';
                            $new_answer->exam_child_question_id = $exams->id;
                            $new_answer->save();

                        }else if($answer['id'] == ''){
                            $new_answer = new ExamAnswers();
                            $new_answer->title = $answer['title'];
                            $new_answer->is_correct = $answer['is_correct'];
                            $new_answer->point = $answer['point'];
                            $new_answer->status = '1';
                            $new_answer->exam_child_question_id = $exams->id;
                            $new_answer->save();
                        }
                    }else if($answer['status'] == '0'){
                        if($answer['id'] != ''){
                            $new_answer = ExamAnswers::findOrFail($answer['id']);
                            $new_answer->delete();

                        }
                    }
                }
            }

            return response()->json(['msg' => 'Exam child question updated successfully.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->role_id == '1'){
            $exams = ExamChildQuestions::findOrFail($id);
            $exams->delete();

            return response()->json(['msg' => 'Exam child question has been deleted successfully.']);

        }
    }
}

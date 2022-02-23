<?php

namespace App\Http\Controllers;

use App\Models\ExamParentQuestions;
use Illuminate\Http\Request;

class ExamParentQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->exam_id) && $request->exam_id != ''){
            return ExamParentQuestions::where('exam_id', $request->exam_id)->with('exam_child_question')->orderBy('id', 'DESC')->get();
        }
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
            $exams = new ExamParentQuestions();
            $exams->fill($request->all())->save();

            return response()->json(['msg' => 'Exam parent question created successfully.']);

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
        return ExamParentQuestions::findOrFail($id);
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
            $exams = ExamParentQuestions::findOrFail($id);
            $exams->fill($request->all())->save();

            return response()->json(['msg' => 'Exam parent question updated successfully.']);

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
        if(auth()->user()->role_id == '1' ){
            $exams = ExamParentQuestions::findOrFail($id);
            $exams->delete();

            return response()->json(['msg' => 'Exam parent question has been deleted successfully.']);

        }
    }
}

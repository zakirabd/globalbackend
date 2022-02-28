<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use App\Models\StudentExamAnswers;
use App\Models\StudentExams;
use App\Services\ExamsService;
use Illuminate\Http\Request;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if(isset($request->query_type) && $request->query_type == 'all'){
        //     return (new ResourcesService($request))->getAllResources();
        // }else{
            return (new ExamsService($request))->getExams();
        // }
    }

    // get public level exams
    public function getLevelExams(Request $request){

        $student_exam = StudentExams::where('student_id', auth()->user()->id)->where('submit', '0')->first();
        if(isset($student_exam)){
            $exams = Exams::findOrFail($student_exam->exam_id)->with('exam_parent_question')->first();
            return $exams;
        }else{
            return response()->json(['msg'=> 'not exam']);
        }

    }

    // submit exams
    public function submitExams(Request $request){

        $student_exam = StudentExams::where('student_id', auth()->user()->id)->where('exam_id', $request->exam_id)->where('submit', '0')->first();
        if(isset($student_exam)){
            $student_exam->over_all = $request->over_all;
            $student_exam->point = $request->point;
            $student_exam->submit = '1';
            $student_exam->save();


            $student_answer_data = json_decode($request->student_answer, true);
            if(isset($student_answer_data) && $student_answer_data != ''){
                foreach($student_answer_data as $item){
                    $student_answers = new StudentExamAnswers();
                    $student_answers->student_id = auth()->user()->id;


                    $student_answers->exam_answer_id = $item['given_answer'] != ''?$item['given_answer']['id']: null;
                    $student_answers->correct_answer_id = $item['correct_answer'] != ''?$item['correct_answer']['id']: null;


                    if($item['given_answer'] != ''){
                        $student_answers->is_correct = $item['given_answer']['is_correct'];
                        $student_answers->point = $item['given_answer']['point'];
                    }else{
                        $student_answers->is_correct = '0';
                        $student_answers->point = '0';
                    }
                    $student_answers->save();
                }
            }

            return response()->json(['msg'=> 'Exam Submitted Successfully', 'code'=> '1']);
        }else{
            return response()->json(['msg' => 'Exam Already Submitted.', 'code'=> '0']);
        }


    }
    public function getExamResults(Request $request){
        $student_exam = StudentExams::where('student_id', auth()->user()->id)->where('submit', '1')->first();
        return $student_exam;
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
            $exams = new Exams();
            $exams->fill($request->all())->save();

            return response()->json(['msg' => 'Exams created successfully.', 'data' => $exams]);

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
        return Exams::findOrFail($id);
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
            $exams = Exams::findOrFail($id);
            $exams->fill($request->all())->save();

            return response()->json(['msg' => 'Exams updated successfully.', 'data' => $exams]);

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
            $exams = Exams::findOrFail($id);
            $exams->delete();

            return response()->json(['msg' => 'Exams has been deleted successfully.']);

        }
    }
}

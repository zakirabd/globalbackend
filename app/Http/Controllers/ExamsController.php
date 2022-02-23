<?php

namespace App\Http\Controllers;

use App\Models\Exams;
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

        $student_exam = StudentExams::where('student_id', auth()->user()->id)->first();
        $exams = Exams::findOrFail($student_exam->exam_id)->with('exam_parent_question')->first();
        return $exams;
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

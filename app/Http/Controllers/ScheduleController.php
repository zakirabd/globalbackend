<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->role_id == "4"){
            return Schedule::where('student_id', auth()->user()->id)->with("teacher")->get();
        }else{
            return Schedule::where('student_id', $request->student_id)->with("teacher")->get();
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
        if(auth()->user()->role_id == '3'){
            $schedule = new Schedule();
            $schedule->fill($request->all());
            $schedule->teacher_id = auth()->user()->id;
            $schedule->save();

            return response()->json(['msg' => 'Schedule created successfully.']);

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
        return Schedule::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Schedule::findOrFail($id);
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
        if( auth()->user()->role_id == '3'){
            $schedule = Schedule::findOrFail($id);
            $schedule->fill($request->all());
            $schedule->teacher_id = auth()->user()->id;
            $schedule->save();

            return response()->json(['msg' => 'Schedule updated successfully.']);

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
            $schedule = Schedule::findOrFail($id);
            $schedule->delete();

            return response()->json(['msg' => 'Schedule has been deleted successfully.']);

        }
    }
}

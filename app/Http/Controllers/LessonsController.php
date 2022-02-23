<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Lessons;
use App\Services\LessonsService;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->query_type) && $request->query_type == 'all'){
            return (new LessonsService($request))->getAllLessons();
        }else{
            return (new LessonsService($request))->getLessons();
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
            $lessons = new Lessons();
            $lessons->fill($request->all());

            if ($request->hasFile('image')) {
                $lessons->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }
            if ($request->hasFile('logo')) {
                $lessons->logo = UploadHelper::imageUpload($request->file('logo'), 'uploads');
            }
            $lessons->save();
            return response()->json(['msg' => 'Lesson created successfully.']);

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
        return Lessons::findOrFail($id);
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
            $lessons = Lessons::findOrFail($id);

            $lessons->fill($request->all());

            if ($request->hasFile('image')) {
                $lessons->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }
            if ($request->hasFile('logo')) {
                $lessons->logo = UploadHelper::imageUpload($request->file('logo'), 'uploads');
            }
            $lessons->save();

            return response()->json(['msg' => 'Lesson updated successfully.']);

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
            $lessons = Lessons::findOrFail($id);
            $lessons->delete();

            return response()->json(['msg' => 'Lesson has been deleted successfully.']);

        }
    }
}

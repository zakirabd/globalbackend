<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Courses;
use App\Services\CoursesService;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->query_type) && $request->query_type == 'all'){
            return (new CoursesService($request))->getAllCourses();
        }else{
            return (new CoursesService($request))->getCourses();
        }
    }



    public function getCoursesById(Request $request, $id){
        return Courses::with('units')->with('category')->findOrFail($id);
    }

    public function getOtherCourses(Request $request, $id){
        return Courses::with('units')->with('category')->where('id', '!=', $id)->get();
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
            $courses = new Courses();
            $courses->fill($request->all());
            if ($request->hasFile('image')) {
                $courses->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }
            if ($request->hasFile('logo')) {
                $courses->logo = UploadHelper::imageUpload($request->file('logo'), 'uploads');
            }
            $courses->save();
            return response()->json(['msg' => 'Courses created successfully.']);

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
        return  Courses::findOrFail($id);
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
            $courses = Courses::findOrFail($id);
            $courses->fill($request->all());
            if ($request->hasFile('image')) {
                $courses->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }
            if ($request->hasFile('logo')) {
                $courses->logo = UploadHelper::imageUpload($request->file('logo'), 'uploads');
            }
            $courses->save();

            return response()->json(['msg' => 'Courses updated successfully.']);

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
            $courses = Courses::findOrFail($id);
            $courses->delete();

            return response()->json(['msg' => 'Courses has been deleted successfully.']);

        }
    }
}

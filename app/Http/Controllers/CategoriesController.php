<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Categories;
use App\Services\CategoriesService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->query_type) && $request->query_type == 'all'){
            return (new CategoriesService($request))->getAllCategories();
        }else if(isset($request->query_type) && $request->query_type == 'class'){
            return (new CategoriesService($request))->getCategoriesWithClass();
        }else {
            return (new CategoriesService($request))->getCategories();
        }

    }

    public function getCategoryById(Request $request, $id){
        return Categories::where('id', $id)->with('courses')->get();
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
            $category = new Categories();
            $category->fill($request->all());
            if ($request->hasFile('image')) {
                $category->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }
            $category->save();

            return response()->json(['msg' => 'Category created successfully.']);

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
        return Categories::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Categories::findOrFail($id);
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
            $category = Categories::findOrFail($id);
            $category->fill($request->all());
            if ($request->hasFile('image')) {
                $category->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }

            $category->save();

            return response()->json(['msg' => 'Category updated successfully.']);

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
            $category = Categories::findOrFail($id);
            $category->delete();

            return response()->json(['msg' => 'Category has been deleted successfully.']);

        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Resources;
use App\Services\ResourcesService;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->query_type) && $request->query_type == 'all'){
            return (new ResourcesService($request))->getAllResources();
        }else{
            return (new ResourcesService($request))->getResources();
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
            $resources = new Resources();
            $resources->fill($request->all())->save();

            return response()->json(['msg' => 'Resources created successfully.']);

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
       return Resources::findOrFail($id);
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
            $resources = Resources::findOrFail($id);
            $resources->fill($request->all())->save();

            return response()->json(['msg' => 'Resources updated successfully.']);

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
            $resources = Resources::findOrFail($id);
            $resources->delete();

            return response()->json(['msg' => 'Resources has been deleted successfully.']);

        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Units;
use App\Services\UnitServices;
use Illuminate\Http\Request;

class UnitControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->query_type) && $request->query_type == 'all'){
            return (new UnitServices($request))->getAllUnits();
        }else{
            return (new UnitServices($request))->getUnits();
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
            $unit = new Units();
            $unit->fill($request->all());
            if ($request->hasFile('image')) {
                $unit->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }
            if ($request->hasFile('logo')) {
                $unit->logo = UploadHelper::imageUpload($request->file('logo'), 'uploads');
            }
            $unit->save();

            return response()->json(['msg' => 'Unit created successfully.']);

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
        return Units::findOrFail($id);
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
            $unit = Units::findOrFail($id);
            $unit->fill($request->all());
            if ($request->hasFile('image')) {
                $unit->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
            }
            if ($request->hasFile('logo')) {
                $unit->logo = UploadHelper::imageUpload($request->file('logo'), 'uploads');
            }
            $unit->save();
            return response()->json(['msg' => 'Unit updated successfully.']);

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
            $unit = Units::findOrFail($id);
            $unit->delete();

            return response()->json(['msg' => 'Unit has been deleted successfully.']);

        }
    }
}

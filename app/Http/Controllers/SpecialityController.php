<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speciality;
use Carbon\Carbon;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = 10;
        if($request->has('per_page')){
            $per_page=$request->per_page;
        }
        $specialties = Speciality::paginate($per_page);

        return response()->json([
            'specialties' => $specialties,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');

        $adminName = $request->user()->name;

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $speciality = Speciality::create([
            'name' => $name,
            'description' => $description,
            'added_timestamp' => $formattedDate,
            'last_changed_admin' => $adminName,
        ]);

        return response()->json([
            'speciality' => $speciality,
            'status' => 'success',
        ], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $speciality = Speciality::find($id);
        return response()->json([
            'speciality' => $speciality,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $adminName = $request->user()->name;

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $speciality = Speciality::find($id);

        $speciality->update($request->all());

        $speciality->update([
            'updated_timestamp' => $formattedDate,
            'last_changed_admin' =>$adminName,
        ]);

        return response()->json([
            'speciality' => $speciality,
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Speciality::destroy($id);
        return response()->json([
            'status' => 'success'
        ], 200);
    }
}

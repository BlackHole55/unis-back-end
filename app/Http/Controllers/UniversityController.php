<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;
use Carbon\Carbon;

class UniversityController extends Controller
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
        $universities=University::paginate($per_page);

        return response([
            'universities' => $universities
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
        ]);
        $description = $request->input('description');
        $location = $request->input('location');
        $link_to_website = $request->input('link_to_website');

        $adminName = $request->user()->name;

        $date = Carbon::now();
        $date->timezone('Asia/Almaty');
        $formattedDate = $date->toIso8601String();

        $university = University::create([
            'name' => $fields['name'],
            'location' => $location,
            'description' => $description,
            'link_to_website' => $link_to_website,
            'added_timestamp' => $formattedDate,
            'last_changed_admin' => $adminName,
        ]);

        return response([
            'university' => $university,
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        return University::where('name', $name)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $adminName = $request->user()->name;

        $date = Carbon::now();
        $date->timezone('Asia/Almaty');
        $formattedDate = $date->toIso8601String();

        $university = University::find($id);

        $university->update($request->all());

        $university->update([
            'updated_timestamp' => $formattedDate,
            'last_changed_admin' =>$adminName,
        ]);

        return response([
            'university' => $university,
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        University::destroy($id);
        return response([
            'status' => 'success'
        ], 200);
    }
}

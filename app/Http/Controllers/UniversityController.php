<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Dorm;
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
        $universities = University::paginate($per_page);

        $universities = University::with(['specialties', 'dorms'])->get();
        

        return response()->json([
            'universities' => $universities
        ], 200);
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
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $university = University::create([
            'name' => $fields['name'],
            'location' => $location,
            'description' => $description,
            'link_to_website' => $link_to_website,
            'added_timestamp' => $formattedDate,
            'last_changed_admin' => $adminName,
        ]);

        return response()->json([
            'university' => $university,
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $university = University::find($id);
        if($university != null){
            $university->loadMissing(['dorms', 'specialties']);
        }

        return response()->json([
            'university' => $university,
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

        $university = University::find($id);

        $university->update($request->all());

        $university->update([
            'updated_timestamp' => $formattedDate,
            'last_changed_admin' =>$adminName,
        ]);

        return response()->json([
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
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    /**
     * Sync without detaching Speciality to University
     */
    public function addSpeciality(Request $request, $id)
    {
        $university = University::find($id);

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $adminName = $request->user()->name;

        $price = $request->input('price');

        $university->specialties()->syncWithoutDetaching([
            $request->speciality => ['price_per_year_tenge' => $price, 'added_timestamp' => $formattedDate, 'last_changed_admin' => $adminName]
        ]);

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Detach Speciality University
     */
    public function removeSpeciality(Request $request, $id)
    {
        $university = University::find($id);

        $university->specialties()->detach($request->speciality);

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Search Universities
     */
    public function search(Request $request)
    {
        $universities_query = University::query();

        $search = $request->input('search');

        if($search){
            $universities_query = University::search($search);
        }

        $universities = $universities_query->get();
        
        return response()->json([
            'universities' => $universities,
        ], 200);
    }
}

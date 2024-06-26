<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\University;
use App\Models\SpecialityUniversity;
use App\Models\Dorm;

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

        $universities = University::with(['specialties', 'dorms'])->paginate($per_page);

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
        $city = $request->input('city');
        $address = $request->input('address');
        $link_to_website = $request->input('link_to_website');

        $adminName = $request->user()->name;

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $university = University::create([
            'name' => $fields['name'],
            'city' => $city,
            'address' => $address,
            'description' => $description,
            'link_to_website' => $link_to_website,
            'added_timestamp' => $formattedDate,
            'last_changed_admin' => $adminName,
        ]);

        return response()->json([
            'university' => $university,
            'success' => 'Successfully created',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $university = University::find($id);

        $specialityUniversity = SpecialityUniversity::where('university_id', $id)->get();

        if($university != null){
            $university->loadMissing(['dorms', 'specialties']);
        }

        if($specialityUniversity != null){
            $specialityUniversity->loadMissing(['exams']);
        }

        return response()->json([
            'university' => $university,
            'specialityUniversity' => $specialityUniversity
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

        $specialityUniversity = SpecialityUniversity::where('university_id', $id)->get();

        if($university != null){
            $university->loadMissing(['dorms', 'specialties']);
        }

        if($specialityUniversity != null){
            $specialityUniversity->loadMissing(['exams']);
        }

        return response()->json([
            'university' => $university,
            'specialityUniversity' => $specialityUniversity,
            'success' => 'Successfully updated'
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
            $universities_query = University::with(['dorms', 'specialties'])->search($search);
        }

        $per_page = 10;
        if($request->has('per_page')){
            $per_page=$request->per_page;
        }

        $universities = $universities_query->paginate($per_page);
        
        return response()->json([
            'universities' => $universities,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dorm;
use Carbon\Carbon;

class DormController extends Controller
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
        $dorms = Dorm::paginate($per_page);

        return response()->json([
            'dorms' => $dorms,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $university_id = $id;
        $description = $request->input('description');
        $city = $request->input('city');
        $address = $request->input('address');
        $price_tenge = $request->input('price_tenge');

        $adminName = $request->user()->name;

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $dorm = Dorm::create([
            'university_id' => $university_id,
            'city' => $city,
            'address' => $address,
            'description' => $description,
            'price_tenge' => $price_tenge,
            'added_timestamp' => $formattedDate,
            'last_changed_admin' => $adminName,
        ]);

        return response()->json([
            'dorm' => $dorm,
            'status' => 'success',
        ], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dorm = Dorm::find($id);
        return response()->json([
            'dorm' => $dorm
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

        $dorm = Dorm::find($id);

        $dorm->update($request->all());

        $dorm->update([
            'updated_timestamp' => $formattedDate,
            'last_changed_admin' =>$adminName,
        ]);

        return response()->json([
            'dorm' => $dorm,
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Dorm::destroy($id);
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    /**
     * Search Universities
     */
    public function search(Request $request)
    {
        $dorms_query = Dorm::query();

        $search = $request->input('search');

        if($search){
            $dorms_query = Dorm::with('university')->search($search);
        }

        $per_page = 10;
        if($request->has('per_page')){
            $per_page=$request->per_page;
        }

        $dorms = $dorms_query->paginate($per_page);
        
        return response()->json([
            'dorms' => $dorms,
        ], 200);
    }
}

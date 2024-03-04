<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use Carbon\Carbon;

class ExamController extends Controller
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
        $exams = Exam::paginate($per_page);

        return response()->json([
            'exams' => $exams
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
        $link_to_website = $request->input('link_to_website');

        $adminName = $request->user()->name;

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $exam = Exam::create([
            'name' => $fields['name'],
            'description' => $description,
            'link_to_website' => $link_to_website,
            'added_timestamp' => $formattedDate,
            'last_changed_admin' => $adminName,
        ]);

        return response()->json([
            'exam' => $exam,
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = Exam::find($id);
        return response()->json([
            'exam' => $exam
        ], 200);
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
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $exam = Exam::find($id);

        $exam->update($request->all());

        $exam->update([
            'updated_timestamp' => $formattedDate,
            'last_changed_admin' =>$adminName,
        ]);

        return response()->json([
            'exam' => $exam,
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Exam::destroy($id);
        return response()->json([
            'status' => 'success'
        ], 200);
    }
}

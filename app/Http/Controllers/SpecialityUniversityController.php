<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialityUniversity;

class SpecialityUniversityController extends Controller
{
    public function show(string $id)
    {
        $specialityUniversity = SpecialityUniversity::find($id);

        if($specialityUniversity != null){
            $specialityUniversity->loadMissing(['exams']);
        }

        return response()->json([
            'speciality' => $specialityUniversity,
        ], 200);
    }

    /**
     * Sync without detaching Exam to speciality_university
     */
    public function addExam(Request $request, $id)
    {
        $specialityUniversity = SpecialityUniversity::find($id);

        $specialityUniversity->exams()->syncWithoutDetaching([$request->exam]);

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Detach Speciality University
     */
    public function removeExam(Request $request, $id)
    {
        $specialityUniversity = SpecialityUniversity::find($id);

        $specialityUniversity->exams()->detach($request->exam);

        return response()->json([
            'status' => 'success',
        ], 200);
    }
}

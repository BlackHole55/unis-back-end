<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;


class SpecialityUniversity extends Pivot
{
    use HasFactory;

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_speciality_university', 'speciality_university_id', 'exam_id');
    }

    protected $table = 'speciality_university';
}

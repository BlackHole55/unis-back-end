<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_speciality_university', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('speciality_university_id')->references('id')->on('speciality_university')->onDelete('cascade');
            $table->foreignId('exam_id')->references('id')->on('exams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_speciality_university');
    }
};

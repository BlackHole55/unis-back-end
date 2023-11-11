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
        Schema::create('speciality_university', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->references('id')->on('universities');
            $table->foreignId('specialty_id')->references('id')->on('specialties');
            $table->integer('price_per_year_tenge')->nullable();
            $table->integer('price_per_year_usd')->nullable();
            $table->string('added_timestamp');
            $table->string('last_changed_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speciality_university');
    }
};

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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialties_id');
            $table->integer('per_year_for_kz');
            $table->integer('per_year_for_foreigners');
            $table->string('added_timestamp');
            $table->string('updated_timestamp')->nullable();
            $table->string('last_changed_admin');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};

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
        Schema::create('dorms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id');
            $table->string('location');
            $table->text('description');
            $table->integer('price_tenge');
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
        Schema::dropIfExists('dorms');
    }
};

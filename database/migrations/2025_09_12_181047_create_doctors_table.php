<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_create_doctors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('restrict');
            $table->string('license_number')->unique();
            $table->string('specialization');
            $table->text('qualifications')->nullable();
            $table->integer('experience_years')->default(0);
            $table->decimal('consultation_fee', 8, 2);
            $table->text('bio')->nullable();
            $table->json('available_days'); // ['monday', 'tuesday', etc.]
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_duration_minutes')->default(30);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index(['department_id', 'is_available']);
            $table->index('license_number');
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_create_appointments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_number')->unique();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', [
                'scheduled', 
                'confirmed', 
                'in_progress', 
                'completed', 
                'cancelled', 
                'no_show'
            ])->default('scheduled');
            $table->text('reason_for_visit')->nullable();
            $table->text('notes')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('prescription')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['doctor_id', 'appointment_date', 'status']);
            $table->index(['patient_id', 'status']);
            $table->index('appointment_number');
            $table->unique(['doctor_id', 'appointment_date', 'appointment_time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
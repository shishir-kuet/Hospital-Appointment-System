<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_create_bills_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number')->unique();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->decimal('consultation_fee', 10, 2);
            $table->decimal('additional_charges', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', [
                'pending', 
                'paid', 
                'partially_paid', 
                'overdue', 
                'cancelled'
            ])->default('pending');
            $table->enum('payment_method', [
                'cash', 
                'card', 
                'bank_transfer', 
                'insurance', 
                'online'
            ])->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['patient_id', 'payment_status']);
            $table->index('bill_number');
            $table->index('payment_status');
            $table->unique('appointment_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
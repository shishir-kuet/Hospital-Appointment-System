<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php
// (Update your existing users migration)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->text('address')->nullable();
            $table->enum('role', ['admin', 'doctor', 'patient'])->default('patient');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['role', 'is_active']);
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
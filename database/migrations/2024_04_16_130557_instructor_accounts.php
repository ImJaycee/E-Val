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
        Schema::create('instructor_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id')->unique();
            $table->string('contact');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('sex');
            $table->string('department');
            $table->string('pfp')->nullable();
            $table->string('password');
            $table->string('password_reset_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_accounts');
    }
};

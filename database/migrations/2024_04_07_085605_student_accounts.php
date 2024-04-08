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
        Schema::create('student_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('contact');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('program');
            $table->string('year')->nullable();
            $table->string('section')->nullable();
            $table->string('pfp')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_accounts');
    }
};

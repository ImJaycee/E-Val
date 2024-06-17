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
        Schema::create('students_token_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('email')->unique();;
            $table->string('eval_token')->unique();
            $table->string('subjet1')->nullable();
            $table->string('subjet2')->nullable();
            $table->string('subjet3')->nullable();
            $table->string('subjet4')->nullable();
            $table->string('subjet5')->nullable();
            $table->string('subjet6')->nullable();
            $table->string('subjet7')->nullable();
            $table->string('subjet8')->nullable();
            $table->string('subjet9')->nullable();
            $table->string('subjet10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_token_accounts');
    }
};

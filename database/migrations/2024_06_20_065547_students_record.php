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
            $table->string('email');
            $table->string('eval_token')->unique();
            $table->string('subject1')->nullable();
            $table->string('subject2')->nullable();
            $table->string('subject3')->nullable();
            $table->string('subject4')->nullable();
            $table->string('subject5')->nullable();
            $table->string('subject6')->nullable();
            $table->string('subject7')->nullable();
            $table->string('subject8')->nullable();
            $table->string('subject9')->nullable();
            $table->string('subject10')->nullable();
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

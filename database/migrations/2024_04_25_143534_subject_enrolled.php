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
        Schema::create('subject_enrolled', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('subject_code');
            $table->string('section');
            $table->string('semester');
            $table->string('A_Y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_enrolled');
    }
};

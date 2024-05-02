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
        Schema::create('student_evaluation', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id');
            $table->string('student_id');
            $table->string('subject_code');
            $table->string('section');
            $table->string('semester');
            $table->string('A_Y');
            $table->string('I-1'); // Part 1 Question1
            $table->string('I-2');
            $table->string('I-3');
            $table->string('II-1'); // Part 2 Question1
            $table->string('II-2');
            $table->string('II-3');
            $table->string('II-4');
            $table->string('III-1'); // Part 3 Question1
            $table->string('III-2');
            $table->string('IV-1'); // Part 4 Question1
            $table->string('IV-2');
            $table->string('V-1'); // Part 5 Question1
            $table->string('V-2');
            $table->string('V-3');
            $table->string('comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_evaluation');
    }
};

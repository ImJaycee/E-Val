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
        Schema::create('peer_evaluation', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id');
            $table->string('evaluator_id');
            $table->string('a_1'); // Part A question 1
            $table->string('a_2');
            $table->string('a_3');
            $table->string('a_4');
            $table->string('a_5');
            $table->string('a_6');
            $table->string('b_1');// Part B question 1
            $table->string('b_2');
            $table->string('b_3');
            $table->string('b_4');
            $table->string('b_5');
            $table->string('b_6');
            $table->string('c_1'); // Part C question 1
            $table->string('c_2');
            $table->string('c_3');
            $table->string('c_4');
            $table->string('c_5');
            $table->string('c_6');
            $table->string('comments');
            $table->string('sentiment');
            $table->string('semester');
            $table->string('A_Y'); // Academic year
            $table->string('A_Total');
            $table->string('B_Total');
            $table->string('C_Total');
            $table->string('overall_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peer_evaluation');
    }
};

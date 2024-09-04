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
        Schema::create('dlc_instructors', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id')->unique();
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('sex');
            $table->string('department');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dlc_instructors');
    }
};

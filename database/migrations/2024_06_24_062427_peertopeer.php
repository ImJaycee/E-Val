<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peer_assignment', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id')->unique();
            $table->string('peer1');
            $table->string('peer2');
            $table->string('peer3');
            $table->string('peer4');
            $table->string('peer5');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peer_assignment');
    }
};

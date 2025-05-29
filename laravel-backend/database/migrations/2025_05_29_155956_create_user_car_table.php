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
         Schema::create('user_car', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('car_id');
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->date('test_drive_date');
        $table->time('test_drive_time');
        $table->timestamps();

        $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_car');
    }
};

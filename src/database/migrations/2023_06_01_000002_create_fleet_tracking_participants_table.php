<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fleet_tracking_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_id');
            $table->unsignedBigInteger('character_id');
            $table->integer('ship_type_id');
            $table->dateTime('join_time');
            $table->dateTime('leave_time')->nullable();
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleet_tracking_fleets')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleet_tracking_participants');
    }
};
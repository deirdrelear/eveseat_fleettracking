<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetTrackingFleetsTable extends Migration
{
    public function up()
    {
        Schema::create('fleet_tracking_fleets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('fc_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->enum('status', ['active', 'inactive', 'completed']);
            $table->string('location');
            $table->string('doctrine')->nullable();
            $table->bigInteger('game_id')->nullable();
            $table->timestamps();

            $table->foreign('fc_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fleet_tracking_fleets');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('insurance_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('trip_bookings')->cascadeOnDelete();
            $table->foreignId('insurance_id')->constrained('insurances')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurance_bookings');
    }
}

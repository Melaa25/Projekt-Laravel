<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetPackageBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('internet_package_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('trip_bookings')->cascadeOnDelete();
            $table->foreignId('internet_package_id')->constrained('internet_packages')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('internet_package_bookings');
    }
}

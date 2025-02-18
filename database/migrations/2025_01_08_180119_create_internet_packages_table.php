<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('internet_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('data_limit', 50)->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('internet_packages');
    }
}

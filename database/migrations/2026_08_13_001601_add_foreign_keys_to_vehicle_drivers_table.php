<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_drivers', function (Blueprint $table) {
            $table->foreign(['driver_id'], 'vehicle_drivers_ibfk_2')->references(['id'])->on('drivers')->onDelete('CASCADE');
            $table->foreign(['vehicle_id'], 'vehicle_drivers_ibfk_1')->references(['id'])->on('vehicles')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_drivers', function (Blueprint $table) {
            $table->dropForeign('vehicle_drivers_ibfk_2');
            $table->dropForeign('vehicle_drivers_ibfk_1');
        });
    }
};

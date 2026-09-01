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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vehicle_name');
            $table->string('vehicle_plate_no')->index('idx_vehicles_plate');
            $table->string('vehicle_model');
            $table->string('vehicle_color');
            $table->date('mulkiya_expiry_date')->nullable();
            $table->enum('status', ['active', 'maintenance', 'inactive'])->nullable()->default('active')->index('idx_vehicles_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->unique(['vehicle_plate_no'], 'vehicle_plate_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};

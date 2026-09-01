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
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('guest_name');
            $table->string('guest_contact_number')->nullable();
            $table->dateTime('pick_up_time');
            $table->dateTime('drop_off_time')->nullable();
            $table->text('pick_up_location');
            $table->text('drop_off_location')->nullable();
            $table->string('service')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable()->index('idx_bookings_vehicle');
            $table->unsignedBigInteger('driver_id')->nullable()->index('idx_bookings_driver');
            $table->enum('payment_method', ['cash', 'credit', 'bank_transfer', 'online'])->nullable();
            $table->integer('no_of_extra_hrs')->nullable()->default(0);
            $table->decimal('basic_amount', 10);
            $table->decimal('extra_hrs_amount', 10)->nullable()->default(0);
            $table->decimal('other_amounts', 10)->nullable()->default(0);
            $table->decimal('gross_total', 10);
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->nullable()->default('pending');
            $table->longText('special_instructions')->nullable();
            $table->longText('cancel_reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index(['pick_up_time', 'drop_off_time'], 'idx_bookings_dates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};

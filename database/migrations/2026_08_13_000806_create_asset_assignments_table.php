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
        Schema::create('asset_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('assignable_type', ['staff', 'driver', 'partner']);
            $table->unsignedBigInteger('assignable_id');
            $table->enum('asset_type', ['pos_machine', 'mobile_phone', 'sim_card']);
            $table->unsignedBigInteger('asset_id');
            $table->date('date_assigned');
            $table->date('date_returned')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index(['assignable_type', 'assignable_id', 'asset_type'], 'idx_asset_assignments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_assignments');
    }
};

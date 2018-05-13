<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardwares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();



            $table->integer('hardwaretype_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('processor_id')->nullable();
            $table->integer('storagetype_id')->nullable();

            $table->string('serial')->nullable();
            $table->string('model_name')->nullable();


            $table->string('hardware_type')->nullable();
            $table->string('brand')->nullable();
            $table->string('processor')->nullable();

            $table->string('ram')->nullable();

            $table->string('storage')->nullable();
            $table->string('storage_type')->nullable();
            $table->date('purchased_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->string('status')->default('Delivered');
            $table->date('deployed_date')->nullable();
            $table->date('disposed_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hardwares');
    }
}

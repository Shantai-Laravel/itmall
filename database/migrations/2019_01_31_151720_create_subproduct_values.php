<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubproductValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subproduct_values', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('sub_product_id')->nullable();
            $table->unsignedInteger('property_id')->nullable();
            $table->unsignedInteger('property_value_id')->nullable();
            $table->timestamps();

            $table->foreign('sub_product_id')->references('id')->on('subproducts')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('product_properties')->onDelete('cascade');
            $table->foreign('property_value_id')->references('id')->on('property_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subproduct_values');
    }
}

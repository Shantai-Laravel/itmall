<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubproducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subproducts', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('product_image_id')->nullable();
            $table->string('code')->nullable();
            $table->string('combination')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('actual_price', 10, 2)->nullable();
            $table->unsignedInteger('discount')->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_image_id')->references('id')->on('product_images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subproducts');
    }
}

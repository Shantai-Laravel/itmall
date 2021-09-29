<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('set_id')->nullable();
            $table->unsignedInteger('promotion_id')->nullable();
            $table->string('alias')->nullable();
            $table->string('code')->nullable();
            $table->string('video')->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('discount')->nullable();
            $table->tinyInteger('hit')->nullable();
            $table->tinyInteger('recomended')->nullable();
            $table->unsignedInteger('position')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('set_id')->references('id')->on('sets')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_translation', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('page_id');
            $table->unsignedInteger('lang_id');
            $table->string('slug');
            $table->string('title');
            $table->text('description');
            $table->text('body');
            $table->string('image');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->text('meta_description');

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');

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
        Schema::dropIfExists('pages_translation');
    }
}

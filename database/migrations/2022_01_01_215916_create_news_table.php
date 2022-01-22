<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('category_news');
            $table->string('subject',256);
            $table->string('slug',256);
            $table->text('preview_text')->nullable();
            $table->text('detail_text')->nullable();
            $table->string('preview_picture')->nullable();
            $table->string('detail_picture')->nullable();
            $table->timestamps();

            $table->unique('slug');
//            $table->foreign('id_category')->references('id')->on('category_news');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}

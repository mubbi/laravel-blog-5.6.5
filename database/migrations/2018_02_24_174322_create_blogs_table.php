<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 150)->nullable(false);
            $table->string('slug', 180)->unique()->nullable(false);
            $table->string('image');
            $table->text('excerpt')->nullable(false);
            $table->longText('description')->nullable(false);
            $table->integer('views')->unsigned()->default(1);
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('is_active')->unsigned()->default(0);
            $table->tinyInteger('allow_comments')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}

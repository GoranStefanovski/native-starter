<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortsPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_shorts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->text('link')->nullable(false);
            $table->integer('user_id')->unsigned();
            $table->integer('event_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('artist_id')->nullable();
            $table->integer('is_active')->nullable();
            $table->json('music_types')->nullable();
            $table->json('location_types')->nullable();
            $table->date('start_active_date')->nullable();
            $table->date('end_active_date')->nullable();
           
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('posts', function (Blueprint $table) {
//            $table->dropForeign('user_id');
//            $table->dropForeign('country_id');
//        });
        Schema::dropIfExists('post_shorts');
    }
}

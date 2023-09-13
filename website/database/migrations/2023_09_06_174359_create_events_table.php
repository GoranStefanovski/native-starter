<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('owner')->nullable(false);
            $table->integer('user_id')->unsigned();
            $table->json('music_types')->nullable();
            $table->integer('location_id')->nullable(null);
            $table->string('location_name')->nullable(false);
            $table->integer('event_type_id')->unsigned();
            $table->integer('is_active')->nullable(false)->default(0);
            $table->integer('activity_going')->unsigned();
            $table->integer('activity_interested')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            // 
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
        Schema::drop('events');
    }
}

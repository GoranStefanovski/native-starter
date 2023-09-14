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

            // Events Information
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('owner')->nullable(false);
            $table->integer('user_id')->unsigned();
            $table->json('music_types')->nullable();
            $table->integer('location_id')->nullable(false);
            $table->string('location_name')->nullable(false);
            $table->string('location_address')->nullable(false);
            $table->integer('is_active')->nullable();


            // Events Activity
            $table->integer('activity_going')->unsigned();
            $table->integer('activity_interested')->unsigned();
            
            
            // Events Timeline & Halls
            $table->date('start_date')->nullable(false);
            $table->date('end_date')->nullable(false);
            $table->json('start_time')->nullable(false);
            $table->json('end_time')->nullable(false);
            
            // Events Contact/Owner
            $table->string('website')->nullable();
            $table->string('website_second')->nullable();
            $table->string('contact_person')->nullable()->unique();
            $table->string('contact_person_second')->nullable();
            $table->string('contact_person_phone')->nullable()->unique();
            $table->string('contact_person__phone_second')->nullable();
            $table->string('contact_person_email')->nullable()->unique();
            $table->string('contact_person_email_second')->nullable();
            
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

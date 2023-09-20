<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false);
            $table->string('owner')->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('country')->nullable(false)->default('Bulgaria');
            $table->integer('country_id')->unsigned();
            $table->string('city')->nullable(false);
            $table->integer('is_active')->nullable();
            $table->string('address')->nullable(false);
            $table->float('rating')->nullable(0.0);
            $table->string('image')->nullable();
            $table->text('description')->nullable(false);
            $table->integer('user_id')->unsigned();
            $table->json('location_types')->nullable();
            $table->integer('activity_going_total')->unsigned();
            $table->integer('activity_interested_total')->unsigned();
            $table->json('working_hours')->nullable();  
            
            // Subscription
            $table->date('start_active_date')->nullable();
            $table->date('end_active_date')->nullable();
            
            // Locations Contact/Owner
            $table->string('website')->nullable();
            $table->string('website_second')->nullable();
            $table->string('contact_person')->nullable()->unique();
            $table->string('contact_person_second')->nullable();
            $table->string('contact_person_phone')->nullable()->unique();
            $table->string('contact_person_phone_second')->nullable();
            $table->string('contact_person_email')->nullable()->unique();
            $table->string('contact_person_email_second')->nullable();
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
        Schema::drop('locations');
    }
}

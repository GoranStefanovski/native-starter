<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_events', function (Blueprint $table) {
        // Events Information
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('owner')->nullable(false);
            $table->string('user_username')->nullable();
            $table->integer('user_id')->unsigned();
            $table->json('music_types')->nullable();
            $table->integer('is_active')->nullable();
            $table->string('address')->nullable(false);
            $table->string('city')->nullable(false);

            // Events Activity
            $table->integer('activity_going')->unsigned();
            $table->integer('activity_interested')->unsigned();
            
            
            // Events Timeline & Halls
            $table->date('start_date')->nullable(false);
            $table->date('end_date')->nullable(false);
            $table->string('start_time')->nullable(false);
            $table->string('end_time')->nullable(false);

            
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
        Schema::drop('organization_events');
    }
}

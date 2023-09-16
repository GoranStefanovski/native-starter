<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned();            
            $table->string('monday_start')->nullable();
            $table->string('monday_end')->nullable();
            $table->integer('monday_working')->nullable();
            $table->string('tuesday_start')->nullable();
            $table->string('tuesday_end')->nullable();
            $table->integer('tuesday_working')->nullable();
            $table->string('wednesday_start')->nullable();
            $table->string('wednesday_end')->nullable();
            $table->integer('wednesday_working')->nullable();
            $table->string('thursday_start')->nullable();
            $table->string('thursday_end')->nullable();
            $table->integer('thursday_working')->nullable();
            $table->string('friday_start')->nullable();
            $table->string('friday_end')->nullable();
            $table->integer('friday_working')->nullable();
            $table->string('saturday_start')->nullable();
            $table->string('saturday_end')->nullable();
            $table->integer('saturday_working')->nullable();
            $table->string('sunday_start')->nullable();
            $table->string('sunday_end')->nullable();
            $table->integer('sunday_working')->nullable();
            $table->integer('open_24')->nullable();

            $table->foreign('location_id')->references('id')->on('locations');

            $table->timestamp('deleted_at')->nullable();
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
        Schema::drop('working_hours');
    }
}

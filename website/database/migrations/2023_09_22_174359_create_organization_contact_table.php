<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            
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
        Schema::drop('organization_contact');
    }
}

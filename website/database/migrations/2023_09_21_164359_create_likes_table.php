<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLikesTable extends Migration {

	public function up()
	{
		Schema::create('likes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('likable_id')->unsigned();
			$table->string('likable_type');
			
            $table->timestamp('deleted_at')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('likes');
	}
}
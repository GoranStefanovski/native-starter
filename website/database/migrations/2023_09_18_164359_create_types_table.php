<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypesTable extends Migration {

	public function up()
	{
		Schema::create('sub_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			
            $table->timestamp('deleted_at')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sub_types');
	}
}
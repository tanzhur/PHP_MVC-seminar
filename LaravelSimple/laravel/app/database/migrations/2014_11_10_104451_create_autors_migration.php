<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorsMigration extends Migration {

	/**
	 * Creates authors table.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('authors',function($table){
			$table->increments("id");
			$table->string("name")->unique();
			$table->text("bio");
			$table->timestamps();//this will add updated_at and created_at timestamps
		});
	}

	/**
	 * Removes authors table.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('authors');
	}
}

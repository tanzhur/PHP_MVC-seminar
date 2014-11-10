<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksMigration extends Migration {

	/**
	 * Create books table.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books',function($table){
			$table->increments('id');
			$table->string('title')->unique();
			$table->text('description');
			//author relation
			$table->integer('author_id')->foreign('author_id')->references('id')->on('authors');					
		});
	}

	/**
	 * Removes books table.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}
}

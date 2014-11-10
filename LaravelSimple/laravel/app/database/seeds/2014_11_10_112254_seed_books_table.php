<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedBooksTable extends Migration {

	/**
	 * Seed books table.
	 *
	 * @return void
	 */
	public function up()
	{	
		$pesho=DB::table('authors')->where('name','=','Pesho')->first();
		$gosho=DB::table('authors')->where('name','=','Gosho')->first();
		//var randomAuthorB=DB::table('authors')->orderByRaw("RAND()")->get();
		//		
		DB::table('books')->insert(array(array(
			'title'=>'Laravel for dummies',
			'description'=>'Laravel for dummies, by dummies who think they know better.',
			'author_id'=>$pesho->id
		),
		array(
			'title'=>'Coding drunk',
			'description'=>'Make programming fun again!',
			'author_id'=>$gosho->id
		)
		));
	}

	/**
	 * Rollback books table seeding.
	 *
	 * @return void
	 */
	public function down()
	{		
		//delete peshos books
		DB::table('books')->whereBetween('title',array('Laravel for dummies','Coding drunk'))->delete();
	}
}

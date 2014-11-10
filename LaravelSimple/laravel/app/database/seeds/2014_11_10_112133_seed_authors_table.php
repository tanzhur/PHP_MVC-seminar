<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedAuthorsTable extends Migration {

	/**
	 * Seed authors table.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('authors')->insert(array(
			array(
				'name'=>'Pesho',
				'bio'=>'Pesho is a well known author of many books about programming.',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			),
			array(
				'name'=>'Gosho',
				'bio'=>'Known for his bestseller "Coding drunk".',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			),
		));
	}

	/**
	 * Rollback authors table seeding.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('authors')->whereBetween('name', array('Gosho', 'Pesho'))->delete();
	}

}

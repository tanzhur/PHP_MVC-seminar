<?php
class Author extends Eloquent
{
	public $table="authors";

	public static $accessible=array('name','bio');

	public static $rules=array(
		'name'=>'required|min:6',
		'bio'=>'required|min:10'
	);

	public static function Validate($data)
	{
		return Validator::make($data,self::$rules);
	}
}
?>
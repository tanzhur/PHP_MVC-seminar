<?php

Route::get('/',array(
	'as'=>'home',
	'uses'=>'HomeController@showWelcome'
));

//get all authors route
Route::get('authors/all/',array(
	'as'=>'all-authors',
	'uses'=>'AuthorsController@ShowAll'
));

//get single author details route
Route::get('author/{id}',array(
	'as'=>'author-details',
	'uses'=>'AuthorsController@ShowAuthorDetails'	
))->where('id', '[0-9]+');

//add new author route
Route::get('authors/create/',array(
	'as'=>'add-author',
	'uses'=>'AuthorsController@AddAuthor'
));

//add new author form post route
Route::post('authors/create/',array(
	'before'=>'csrf',
	'uses'=>'AuthorsController@PostAddAuthor'
));

//edit author route
Route::get('author/{id}/edit',array(
	'as'=>'edit-author',
	'uses'=>'AuthorsController@EditAuthor'
))->where('id', '[0-9]+');

//edit author route
Route::post('author/edit',array(
	'before'=>'csrf',
	'uses'=>'AuthorsController@PostEditAuthor'

));

//delete author route
Route::get('author/{id}/delete',array(
	'as'=>'delete-author',
	'uses'=>'AuthorsController@DeleteAuthor'
))->where('id', '[0-9]+');
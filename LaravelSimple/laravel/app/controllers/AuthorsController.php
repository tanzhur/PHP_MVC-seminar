<?php
class AuthorsController extends BaseController
{
	public function ShowAll()
	{
		$data=array(
			'title'=>'All authors',
			'authors'=>Author::orderBy('name')->get()
		);
		
		$this->RenderView("authors.all", $data);
	}
	
	public function ShowAuthorDetails($id)
	{
		$data=array(
			'title'=>'Author details',
			'author'=>Author::where('id','=',$id)->first()
		);
		
		$this->RenderView('authors.details',$data);
	}
	
	public function AddAuthor()
	{
		$data=array(
			'title'=>'Add new author'			
		);
		
		$this->RenderView('authors.add',$data);
	}
	
	public function PostAddAuthor()
	{
		$validation=Author::Validate(Input::All());

		if($validation->fails())
		{
			//validation failed
			return Redirect::route('add-author')->withErrors($validation)->withInput();
		}

		//create and save new author
		$author=new Author();
		$author->name=Input::get('name');
		$author->bio=Input::get('bio');
		$author->created_at=date('Y-m-d H:m:s');
		$author->updated_at=date('Y-m-d H:m:s');
		$author->save();

		//redirect to authors list
		return Redirect::route('all-authors')->with('message', 'Author added!');
	}

	public function EditAuthor($id)
	{
		$author=Author::where('id','=',$id)->first();
		$data=array(
			'title'=>'Edit author',
			'author'=>$author
		);

		$this->RenderView('authors.edit',$data);
	}

	public function PostEditAuthor()
	{
		$validation=Author::Validate(Input::All());

		if($validation->fails())
		{
			//validation failed
			return Redirect::route('edit-author',array('id'=>Input::get('id')))->withErrors($validation)->withInput();
		}
		$authorToEdit=Author::where('id','=',Input::get('id'))->first();
		//alter and save author
		$authorToEdit->name=Input::get('name');
		$authorToEdit->bio=Input::get('bio');
		$authorToEdit->updated_at=date('Y-m-d H:m:s');
		$authorToEdit->update();

		//redirect to author page
		return Redirect::route('author-details',array('id'=>Input::get('id')))->with('message', 'Author updated!');
	}

	public function DeleteAuthor($id)
	{
		$authorToDelete=Author::where('id','=',$id)->first();
		$authorToDelete->delete();

		return Redirect::route('all-authors')->with('message', 'Author deleted!');
	}
}
?>
@layout('common.layout')

@section('content')
	{{ View::make('authors.common.validation') }}
	
	{{Form::open(array('url'=>'authors/create', 'method'=>'POST'))}}
		{{Form::token()}}
		{{Form::label('name','Author name')}}	
		<br/>
		{{Form::text('name',Input::old('name'))}}
		<br/>
		{{Form::label('bio','Author bio')}}	
		<br/>
		{{Form::textarea('bio',Input::old('bio'))}}
		<br/>
		{{Form::submit('Add author')}}
	{{Form::close()}}
	<a href="{{ URL::route('all-authors') }}">Back to authors list</a>
@endsection
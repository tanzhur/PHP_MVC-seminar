@layout('common.layout')

@section('content')
	{{ View::make('authors.common.validation') }}
	
	{{Form::open(array('url'=>'author/edit', 'method'=>'POST'))}}
		{{Form::hidden('id',$author->id)}}
		{{Form::token()}}
		{{Form::label('name','Author name')}}	
		<br/>
		{{Form::text('name',$author->name)}}
		<br/>
		{{Form::label('bio','Author bio')}}	
		<br/>
		{{Form::textarea('bio',$author->bio)}}
		<br/>
		{{Form::submit('Edit author')}}
	{{Form::close()}}
	<a href="{{ URL::route('all-authors') }}">Back to authors list</a>
@endsection
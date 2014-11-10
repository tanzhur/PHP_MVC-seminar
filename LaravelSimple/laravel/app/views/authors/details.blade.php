@layout('common.layout')

@section('content')
	{{ View::make('authors.common.messages') }}
	<h3>{{$author->name}}</h3>
	<p>{{$author->bio}}</p>
	<a href="{{ URL::route('edit-author',array('id'=>$author->id))}}">Edit</a>
	<a href="{{ URL::route('delete-author',array('id'=>$author->id))}}">Delete</a>
	<a href="{{ URL::route('all-authors')}}">Back to authors list</a>
@endsection
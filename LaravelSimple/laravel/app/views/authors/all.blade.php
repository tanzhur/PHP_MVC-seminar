@layout('common.layout')

@section('content')
	{{ View::make('authors.common.messages') }}
	<a href="{{URL::route('add-author')}}">Add new author</a>
	<dl>	
		@foreach($authors as $author)
			<dt>
				<a href="{{ URL::route('author-details',array('id'=>$author->id)) }}">{{$author->name}}</a>
			</dt>
			<dd>
				{{$author->bio}}
			</dd>
		@endforeach
	</dl>
@endsection
@layout('common.layout')

@section('header')
	<h1><a href="{{ URL::route('home')}}">Books App</a></h1>
	<nav>
		<ul>
			<li>
				<a href="{{ URL::route('all-authors')}}">Authors</a>
			</li>
		</ul>
	</nav>
	<hr/>
@endsection
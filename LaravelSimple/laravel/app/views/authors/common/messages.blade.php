@if(Session::has('message'))
	{{Session::get('message')}}
	<br/>
@endif
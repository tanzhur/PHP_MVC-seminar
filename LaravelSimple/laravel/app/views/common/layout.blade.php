<html>
<head>
	<META charset="Utf8"/>
	<title>Books App - {{$title}}</title>	
</head>
<body>
	<header>
		@yield('header')
	</header>
	<section>
		<h2>{{$title}}</h2>
		@yield('content')
	</section>
	<footer>
		@yield('footer')
	</footer>
</body>
</html>
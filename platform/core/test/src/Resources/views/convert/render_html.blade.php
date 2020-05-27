<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>

	</style>
</head>
<body>
	<div class="container" style="max-width: 1140px;width: 100%;margin: 0 auto">
		@foreach($html->getAllPages() as $page)
			{!! $page !!}
		@endforeach
	</div>
</body>
</html>
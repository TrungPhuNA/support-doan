<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="favicon.ico">

	<title> System Test | Trung Phu NA</title>

	<!-- Bootstrap core CSS -->
	<link href="{{ asset('static_test/css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="{{ asset('static_test/css/dashboard.css') }}" rel="stylesheet">
	<style>
		.nav-link {
			padding: 0.2rem 1rem;
		}
	</style>
</head>

<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
	<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
	<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
	<ul class="navbar-nav px-3">
		<li class="nav-item text-nowrap">
			<a class="nav-link" href="#">Sign out</a>
		</li>
	</ul>
</nav>

<div class="container-fluid">
	<div class="row">
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<div class="sidebar-sticky">
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('get.test.upload_multiple_document.add') }}">
							Upload Multiple
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('get.test.pdf_to_html') }}">
							Pdf To Html
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('get.test.file_to_png') }}">
							File To PNG
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('get.test.create_thumbnail') }}">
							Create Thumbnail
						</a>
					</li>
				</ul>
				<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
					<span>Email</span>
					<a class="d-flex align-items-center text-muted" href="#">
						<span data-feather="plus-circle"></span>
					</a>
				</h6>
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('get.test.email') }}">
							Send email
						</a>
					</li>
				</ul>

				<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
					<span>Thông báo</span>
					<a class="d-flex align-items-center text-muted" href="#">
						<span data-feather="plus-circle"></span>
					</a>
				</h6>
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('get.test.pusher_index') }}">
							Pusher
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
			@yield('content-test')
		</main>
	</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="{{ asset('static_test/js/js/popper.min.js') }}"></script>
<script src="{{ asset('static_test/js/js/bootstrap.min.js') }}"></script>
@yield('script')
</body>
</html>

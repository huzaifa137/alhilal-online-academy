<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="COMESA EPROCUREMENT SYSTEM" name="description">
		<meta name="keywords" content="COMESA eProcurement, COMESA procurement system, eProcurement solutions COMESA, COMESA digital procurement, COMESA electronic tendering, COMESA online procurement, COMESA procurement platform, eTendering COMESA, COMESA procurement software, COMESA eTendering system, COMESA electronic procurement system, COMESA procurement management, COMESA eProcurement tools, COMESA procurement automation, COMESA procurement technology
"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
		@include('layouts-side-bar.head')
	</head>

	<body class="app sidebar-mini light-mode default-sidebar">
		<!---Global-loader-->
		<div id="global-loader" >
			<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
		</div>

		<div class="page">
			<div class="page-main">
				@include('layouts-side-bar.side-menu')
				<div class="app-content main-content">
					<div class="side-app">
						@include('layouts-side-bar.header')
						@yield('page-header')
						@yield('content')
            			@include('layouts-side-bar.footer')
		</div><!-- End Page -->
			@include('layouts-side-bar.footer-scripts')	
	</body>
</html>
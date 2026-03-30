<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta content="COMESA EPROCUREMENT SYSTEM" name="description">
		<meta name="keywords" content="COMESA eProcurement, COMESA procurement system, eProcurement solutions COMESA, COMESA digital procurement, COMESA electronic tendering, COMESA online procurement, COMESA procurement platform, eTendering COMESA, COMESA procurement software, COMESA eTendering system, COMESA electronic procurement system, COMESA procurement management, COMESA eProcurement tools, COMESA procurement automation, COMESA procurement technology
"/>	
        <meta name="csrf-token" content="{{ csrf_token() }}">
		
		@include('layouts-side-bar.custom-head')
		
	</head>
		
	<body class="h-100vh page-style1 light-mode default-sidebar">	    
		@yield('content')		
		@include('layouts-side-bar.custom-footer-scripts')	
	</body>
</html>
<!doctype html>
<html lang="en">
  <head>
  	<title>JustAgain </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{asset('css/style.css')}}">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
	  		<h1><a href="{{url('/admin/dashboard')}}" class="logo">Hi, {{ Auth::user()->name }}</a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="{{url('/dashboard')}}"><span class="fa fa-book mr-3"></span>Dashboard</a>
          </li>
         <li class="active">
            <a href="{{url('/result')}}"><span class="fa fa-list-alt mr-3"></span>Results</a>
          </li>
          <li>
            <a href="{{url('/logout')}}"><span class="fa fa-sign-out mr-3"></span> Logout</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
              <div id="content" class="p-4 p-md-5 pt-5">
                @yield('space-work')
              </div>
		</div>

<!--    <script src="{{asset('js/jquery.min.js')}}"></script>-->
    <script src="{{asset('js/popper.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
  </body>
</html>
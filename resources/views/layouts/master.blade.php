<?php
// set default character set
ini_set('default_charset', 'UTF-8');

$sitetitle = 'ATC Delivery';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        @if(isset($title) )
        {{ $title }} | 
        @endif
        {{ $sitetitle }}
    </title>

    <!-- Bootstrap core CSS -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">{{ $sitetitle }}</a>

        @if(Auth::check() )
            <p class="navbar-text">Hello, <a href="/">{{ Auth::user()->name }}</a>
            </p>
        @endif
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          @if(Auth::check() && Auth::user()->role == 'staff')
          <ul class="nav navbar-nav">
            <li><a href="/students">List Students</a></li>
            <li><a href="/files">List Files</a></li>
            <li><a href="/courses">List Courses</a></li>
            <li><a href="/students/create">Add Student</a></li>
          </ul>
          @endif

          <ul class="nav navbar-nav navbar-right">
            @if(Auth::guest() )
                <li><a href="/google/authorize">Login with Google</a></li>
            @else
                <li><a href="/logout">Logout</a></li>
            @endif
                <li><a href="https://accounts.google.com/logout">Logout of Google</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>

    </nav>

    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
    @if(\Session::has('flash_message'))
        <div class='alert alert-warning' role="alert">
            {{ \Session::get('flash_message') }}
        </div>
    @endif

        {{-- Main page content will be yielded here --}}
        @yield('content')
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/javascripts/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script async src="/javascripts/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

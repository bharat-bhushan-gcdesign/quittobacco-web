<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>AVI Admin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!--global styles-->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/components.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/custom.css" />
    <!-- <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/style.css" /> -->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/index.css">
    <link type="text/css" rel="stylesheet" href="#" id="skin_change" />
  

</head>

<body class="body">
<div class="preloader" style=" position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 100000;
  backface-visibility: hidden;
  background: #ffffff;">
    <div class="preloader_img" style="width: 200px;
  height: 200px;
  position: absolute;
  left: 48%;
  top: 48%;
  background-position: center;
z-index: 999999">
        <img src="{{url('/')}}/img/loader.gif" style=" width: 50px;" alt="loading...">
    </div>
</div>
<?php
if(Auth::check()){
$userdetails =  App\Models\Users::where('id',Auth::user()->id)->first(); 
$name = ($userdetails->first_name!="") ? $userdetails->first_name : "User";
$profileimage = ($userdetails->profile_img!=null) ? $userdetails->profile_img : "defaultprofile.jpg";
}
?>

@if(Auth::check())
<div id="wrap">
    <div id="top">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top">
            <div class="container-fluid m-0">
                <a class="navbar-brand" href="{{url('/')}}">
                    <h4>  <img src="{{url('/')}}/img/logo2png.png"  class="avi_logo" alt="logo_img" width="30px"/> <span>Dashboard</span></h4>
                </a>
                <div class="menu mr-sm-auto">
                    <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </span>
                </div>
            
                <div class="btn-group">
                    <div class="user-settings no-bg">
                        <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                            <img src="{{url('/')}}/uploads/userimage/{{$profileimage}}" class="admin_img2 img-thumbnail rounded-circle avatar-img"
                                 alt="avatar"> <strong>{{$name}}</strong>
                            <span class="fa fa-sort-down white_bg"></span>
                        </button>
                        <div class="dropdown-menu admire_admin">
                       <!--      <a class="dropdown-item title" href="{{url('/')}}">
                                AVI Admin</a> -->
                            <a class="dropdown-item title" href="{{url('/')}}/editprofile/{{$userdetails->id}}"><i class="fa fa-cogs"></i>
                                Update Profile</a>
                            <a class="dropdown-item" href="{{url('/')}}/changepassword"><i class="fa fa-pencil"></i>
                                Change Password</a>
                            <a class="dropdown-item 1" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>
                                Log Out</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- /.navbar -->
        <!-- /.head -->
    </div>
    <!-- /#top -->
    @else
    <script>
            window.location.href = "{{url('/login')}}";
    </script>
      @endif


@include('sidebar')

       
        <!-- /#left -->
        <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar">
                    <div class="row no-gutters">
                        <div class="col-6">
                            <h4 class="m-t-5">
                                <i class="fa fa-home"></i>
                                Dashboard
                            </h4>
                        </div>
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">


                    <!--top section widgets-->
                    <div class="row widget_countup">
                        <div class="col-12 col-sm-6 col-xl-4">

                            <div id="top_widget11" class="minset">
                                <div class="front">
                                    <div class="bg-primary bg-cmn p-d-15 b_r_5">
                                        <a href="{{url('/users')}}" style="outline: none;">
                                        <div class="float-right m-t-5">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div id="widget_countup"><h1>{{$users}}</h1></div>
                                       
                                        <div class="previous_font">Active Users</div>
                                    </a>
                                    </div>
                                </div>
                              
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-4 media_max_573">
                            <div id="top_widget21" class="minset">
                                <div class="front">
                                    <div class="bg-success bg-cmn p-d-15 b_r_5">
                                         <a href="{{url('/restaurants')}}" style="outline: none;">
                                        <div class="float-right m-t-5">
                                            <i class="fa fa-cutlery"></i>
                                        </div>
                                       
                                        <div id="widget_countup"><h1>{{$restaurant}}</h1></div>
                                        
                                        <div class="previous_font">Active Restaurants</div>
                                    </a>
                                    </div>
                                </div>

                             </div>

                        </div>
                        <div class="col-12 col-sm-6 col-xl-4 media_max_1199">
                            <div id="top_widget31" class="minset">
                                <div class="front">
                                    <div class="bg-warning bg-cmn p-d-15 b_r_5">
                                    <a href="{{url('/airport')}}" style="outline: none;">
                                        <div class="float-right m-t-5">
                                            <i class="fa fa-plane"></i>
                                        </div>
                                       
                                        <div id="widget_countup"><h1>{{$airports}}</h1></div>
                                       
                                        <div class="previous_font">Active Airports</div>
                                    </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="box-body" >
                            <canvas id="bar-chart"style="max-width: 450px; width: 100%; height: 400px; margin: 0 auto;
                            display: block;  margin-top: 50px;  border: 1px solid #ddd;  padding: 20px; margin-left:100px;" height="400"></canvas>
                        </div> 
                        <div class="box-body" >
                            <canvas id="bar-chart1"style="max-width: 450px; width: 100%; height: 400px; margin: 0 auto;
                            display: block;  margin-top: 50px;  border: 1px solid #ddd;  padding: 20px; margin-left:50px;" height="400"></canvas>
                        </div> 
                        <div class="box-body" >
                            <canvas id="pie-chart"style="max-width: 450px; width: 100%; height: 400px; margin: 0 auto;
                            display: block;  margin-top: 50px;  border: 1px solid #ddd;  padding: 20px; margin-left:50px;" height="400"></canvas>
                        </div> 
                         <div class="box-body" >
                            <canvas id="bar-chart2"style="max-width: 450px; width: 100%; height: 400px; margin: 0 auto;
                            display: block;  margin-top: 50px;  border: 1px solid #ddd;  padding: 20px; margin-left:50px;" height="400"></canvas>
                        </div>   
                        <div class="box-body" >
                            <canvas id="bar-chart3"style="max-width: 450px; width: 100%; height: 400px; margin: 0 auto;
                            display: block;  margin-top: 50px;  border: 1px solid #ddd;  padding: 20px; margin-left:50px;" height="400"></canvas>
                        </div> 
                </div>
               
            <!-- # right side -->
</div>
<!-- /#wrap -->

</body>

</html>            
        
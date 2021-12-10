<!doctype html>

<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tobacco App</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link rel="shortcut icon" href="https://whoapp.dci.in/uploads/userimage/who-LOGO.png"/>
    
    <link rel="shortcut icon" href=""/>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/bootstrap-glyphicons.css" />
   <!--global styles-->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/components.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/custom.css" />
    <!-- <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/style.css" /> -->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/index.css">
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/chartist.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//chartist/css/chartist.min.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//circliful/css/jquery.circliful.css">
    <link type="text/css" rel="stylesheet" href="#" id="skin_change" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//switchery/css/switchery.min.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//radio_css/css/radiobox.min.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//checkbox_css/css/checkbox.min.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//inputlimiter/css/jquery.inputlimiter.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//chosen/css/chosen.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//bootstrap-colorpicker/css/bootstrap-colorpicker.min.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//jquery-tagsinput/css/jquery.tagsinput.min.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//daterangepicker/css/daterangepicker.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//datepicker/css/bootstrap-datepicker.min.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//bootstrap-switch/css/bootstrap-switch.min.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//jasny-bootstrap/css/jasny-bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//multiselect/css/multi-select.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//jquery-validation-engine/css/validationEngine.jquery.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//datepicker/css/bootstrap-datepicker.min.css">
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//datepicker/css/bootstrap-datepicker3.css">
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//datetimepicker/css/DateTimePicker.min.css">
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//bootstrapvalidator/css/bootstrapValidator.min.css" />
    <!--plugin styles-->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//select2/css/select2.min.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//datatables/css/scroller.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//datatables/css/colReorder.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors//datatables/css/dataTables.bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/dataTables.bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/plugincss/responsive.dataTables.min.css" />
    
    <!-- end of plugin styles -->
    <!--End of Plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/radio_checkbox.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/form_elements.css"/>
    <link href="{{url('/')}}/css/pages/flot_charts.css" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/tables.css" />
    <link type="text/css" rel="stylesheet" href="#" id="skin_change" />

    <link type="text/css" rel="stylesheet" href="{{url('/')}}/assets/fileinput/fileinput.min.css" />
  

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
$userdetails =  App\User::where('id',Auth::user()->id)->first(); 
$name = ($userdetails->name!="") ? $userdetails->name : "User";
$profileimage = ($userdetails->profile_image!=null) ? $userdetails->profile_image : "defaultprofile.jpg";
}
?>

@if(Auth::check())
<div id="wrap">
    <div id="top">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top">
            <div class="container-fluid m-0">
                <a class="navbar-brand" href="{{url('/')}}">
                    <h4>  <img src="{{url('/')}}/defaults/logo.png"  class="avi_logo" alt="logo_img" width="30px"/> <span>Dashboard</span></h4>
                    
                    <!-- <h4>  <img src="{{url('/')}}/img/buskerlogo.png"  class="avi_logo" alt="logo_img" width="30px"/> <span>Dashboard</span></h4> -->
                </a>
                <div class="menu mr-sm-auto">
                    <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </span>
                </div>
            
                <div class="btn-group">
                    <div class="user-settings no-bg">
                        <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                            @if(Auth::User()->profile!=null)
                                <img class="admin_img2 img-thumbnail rounded-circle avatar-img" alt="User Picture" src="{{url('/')}}/uploads/files/{{$userdetails->profile->name}}" onerror="this.onerror=null; this.src='{{url('/')}}/uploads/dummy/userdefault.png'">
                            @else
                               <img class="admin_img2 img-thumbnail rounded-circle avatar-img" alt="User Picture" src="{{url('/')}}/uploads/dummy/userdefault.png">
                            @endif
                           <strong>{{$name}}</strong>
                            <span class="fa fa-sort-down white_bg"></span>
                        </button>
                        <div class="dropdown-menu admire_admin">
                       <!--      <a class="dropdown-item title" href="{{url('/')}}">
                                AVI Admin</a> -->
                            <a class="dropdown-item title" href="{{url('/')}}/editprofile/{{$userdetails->code}}"><i class="fa fa-cogs"></i>
                                Update Profile</a>
                            <a class="dropdown-item" href="{{url('/')}}/get-password"><i class="fa fa-pencil"></i>
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

<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script>
  
    var firebaseConfig = {
         apiKey: "AIzaSyAa3vfkbLaDCzPakAl_LYI8sScgQW8WhEQ",
    authDomain: "who-app-615c6.firebaseapp.com",
    databaseURL: "https://who-app-615c6.firebaseio.com",
    projectId: "who-app-615c6",
    storageBucket: "who-app-615c6.appspot.com",
    messagingSenderId: "765623951630",
    appId: "1:765623951630:web:494b34ddf2d96e668fb75f",
    measurementId: "G-M8GGVLF90Z"
    };
      
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
  
    function initFirebaseMessagingRegistration() {
                console.log('token');

            messaging

            .requestPermission()
            .then(function () {
                console.log(messaging.getToken());
                
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);
   
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
  
                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log('Token saved successfully');
                    },
                    error: function (err) {
                        console.log('User Chat Token Error'+ err);
                    },
                });
  
            }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
     }  
      
    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });
   
</script>

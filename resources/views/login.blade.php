<!DOCTYPE html>
<html>
    <head>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <title>Tobacco App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="shortcut icon" href="https://whoapp.dci.in/uploads/userimage/who-LOGO.png"/>
        <!--Global styles -->
        <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/components.css" />
        <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/custom.css" />
        <!--End of Global styles -->
        <!--Plugin styles-->
        <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors/wow/css/animate.css"/>
        <!--End of Plugin styles-->
        <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/login.css"/>
        <style type="text/css">
        .Err3, .Err1, .Err2,.Err4,.Err5,.Err6 { display:none; color:red!important; }
        </style>
    </head>

    <body style="background-color:  #1d5b99 !important; background-image: none;">
        <div class="preloader" 
            style=" position: fixed;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                z-index: 100000;
                backface-visibility: hidden;
                background: #ffffff;">
        <div class="preloader_img" 
            style="width: 200px;
                height: 200px;
                position: absolute;
                left: 48%;
                top: 48%;
                background-position: center;
                z-index: 999999">
            <img src="{{url('/')}}/img/loader.gif" style=" width: 40px;" alt="loading...">
        </div>
    </div>
    <div class="container wow fadeInDown" data-wow-delay="0.5s" data-wow-duration="2s">
        <div class="login_top_bottom">
            <div class="row">
                <div class="col-lg-6  col-md-8  col-sm-12 md_log_left">
                    <div class="login_logo login_border_radius1">
                        <h3 class="">
                        </h3>
                    </div>
                    <div class="col-lg-12  col-md-12  col-sm-12 avi_logos">
                        <h1>WHO</h1> 
			                 <img src="http://whoapp.dci.in/uploads/userimage/who-LOGO.png"   alt="logo_img" width="200px"/>
                        <!--<img src="{{url('/')}}/img/678.jpg" class="login-img">-->
                        <div class="md_left_imgtext">
                            <!---<p>A Sample and intelligent to-do list that makes it easy to plan your day</p>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6  col-md-8  col-sm-12 md_log_right">
                    <div class="bg-white login_content login_border_radius">
                        <form action="{{url('/')}}/" id="loginform" method="post" class="login_validator">
                            <h3 class="md_helo">Hello there !</h3>
                            <h5>Login your account</h5>
                            <div class="form-group">
                                <label for="email" class="col-form-label"> E-mail</label>
                                <div id="email_inner">
                                    <label class="control-label Err3" for="inputError"></i>Invalid E-mail or Password</label>
                                    <label class="control-label Err4" for="inputError"></i>Your Account is Inactivated</label>
                                    <label class="control-label Err5" for="inputError"></i>Your Account is Deleted</label>
 <label class="control-label Err6" for="inputError"></i>Recap</label>

                                    <div class="input-group">
                                        <span class="input-group-addon input_email"><i class="fa fa-envelope text-primary"></i></span>
                                        <input type="text" class="form-control  form-control-md" id="email" name="username" placeholder="E-mail">
                                    </div>
                                    <label class="control-label Err1" for="inputError"></i>E-mail  is required</label>
                                    <label class="control-label Err2" for="inputError"></i>E-mail  is invalid</label>
                                </div>
                            </div>
                            <!--</h3>-->
                            <div class="form-group">
                                <div id="password_inner">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon addon_password"><i class="fa fa-lock text-primary"></i></span>
                                            <div class="input-group" id="show_hide_password">
                                                <input class="form-control" id="password" name="password" type="password">
                                                <div class="input-group-addon">
                                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="control-label Err1" for="inputError"></i>Password field is required</label>
                                </div>
                            </div>
                            @if(config('services.recaptcha.key'))
                                <div class=" mt-3 g-recaptcha"
                                    data-sitekey="{{config('services.recaptcha.key')}}">
                                </div>
                                <div id="captcha_inner">

                                    <label class="control-label Err6" for="inputError"></i>Re-captcha is Required</label>
                                </div>
                            @endif
                            <div class="form-group mt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input form-control" name="remember">
                                            <span class="custom-control-indicator"></span>
                                            <a class="custom-control-description">Remember Me</a>
                                        </label>
                                    </div>
                                    <div class="col-6 text-right ">
                                        <input type="hidden" name="_token" id="csrftoken" value="{{ csrf_token() }}">
                                        <input type="button" class="btn btn-primary btn-block login_button" onclick="return validation();" value="Submit">
                                    </div>
                                    <div>
                                        <span class="psw">Forgot <a href="http://whoapp.dci.in/forgotpassword">password?</a></span>
                                    </div>
                                </div>
                            </div>

                            

                             <!--<div class="form-group forgot_pwd">
                                <a href="{{url('forgotpassword')}}" class="custom-control-description forgottxt_clr">Forgot password?</a>
                             </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- global js -->
    <script type="text/javascript" src="{{url('/')}}/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/popper.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/bootstrap.min.js"></script>
    <!-- end of global js-->
    <!--Plugin js-->
    <script type="text/javascript" src="{{url('/')}}/vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/vendors/wow/js/wow.min.js"></script>
          <!--End of plugin js-->
    <script type="text/javascript" src="{{url('/')}}/js/pages/login1.js"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "fa-eye-slash" );
                    $('#show_hide_password i').removeClass( "fa-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "fa-eye-slash" );
                    $('#show_hide_password i').addClass( "fa-eye" );
                }
            });
        });

        function validation()
        {
             //$(':input[type="submit"]').prop('disabled', true);
            var email=$('#email').val();
            var password=$('#password').val();

            $('.Err1').hide();
            $('.Err2').hide();
            $('.Err3').hide();
            var err='';

            if(email=="")
            {
                $('#email').addClass('has-error');
                $('#email_inner .Err1').show();
                if(err=='')
                {
                    $('#email').focus();
                    err='set';
                }
            }
            if(email!="")
            {
                var patterns = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                if(!patterns.test(email))
                {
                    $('#email').addClass('has-error');
                    $('#email_inner .Err2').show();
                    if(err=='')
                    {
                        $('#email').focus();
                        err='set';
                    }
                }
            } 
            if(password=="")
            {
                $('#password').addClass('has-error');
                $('#password_inner .Err1').show();
                if(err=='')
                {
                    $('#password').focus();
                    err='set';
                }
            } 

            if(err!='')
            {
                $(':input[type="submit"]').prop('disabled', false);
                return false;
            }
            else
            {
                $.ajax({
                    type : "POST",
                    url : "{{ url('/') }}/checklogin",
                    data : $('#loginform').serializeArray(),
                    beforeSend : function() {
                    },
                    success : function(data) {
                        if(data==1) {
                            //form.submit();
                            window.location ="{{ url('/') }}/dashboard";
                        }
                        else if(data==2)
                        {
                            $('#email_inner .Err4').show();
                            $(':input[type="submit"]').prop('disabled', false);
                            return false;
                        } 
                        else if(data==3)
                        { 
                            $('#email_inner .Err5').show();
                            $(':input[type="submit"]').prop('disabled', false);
                            return false;
                        } 
                        else if(data==4)
                        { 

                            $('#captcha_inner .Err6').show();
                            $(':input[type="submit"]').prop('disabled', false);
                            return false;
                        } 
                        else
                        {
                            $('#email_inner .Err3').show();
                            $(':input[type="submit"]').prop('disabled', false);
                            return false;
                        }
                    },
                    error : function(xhr, ajaxOptions, thrownError) {
                    },
                });  
            }
        }
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        $("#email, #password").keypress(function(e) {
    	    if(e.which == 13) {
    	        validation();
    	    }
    	});

    </script>

    
    </body>
</html>
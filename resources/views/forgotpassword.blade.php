<!DOCTYPE html>
<html>
   <head>
      <title>Forgot Password</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="shortcut icon" href="img/logo1.ico"/>
      <!--Global styles -->
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/components.css" />
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/custom.css" />
      <!--End of Global styles -->
      <!--Plugin styles-->
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/bootstrap.min.css"/>
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors/wow/css/animate.css"/>
      <!--End of Plugin styles-->
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/login.css"/>
   </head>
   <style type="text/css">
     .Err { display:none; color:red!important; }
     .successmail { font-size: 16px;font-weight: bold;color: green; }
     .failuremail { font-size: 16px;font-weight: bold;color: red; }
</style>
   <body style="background-color: #1d5b99 !important; background-image: none;">
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
            <img src="{{url('/')}}/img/loader.gif" style=" width: 40px;" alt="loading...">
         </div>
      </div>
      <div class="container wow fadeInDown" data-wow-delay="0.5s" data-wow-duration="2s">
            <div class="login_top_bottom">
               <div class="row">
                  <div class="col-lg-6  col-md-8  col-sm-12 md_log_left">
                     <div class="login_logo login_border_radius1">
                        <h3 class="">
                         <!--  <img src="img/logo3png.png"  class="avi_logo" alt="logo_img" width="60px"/>-->
                        </h3>
                     </div>
                     <div class="col-lg-12  col-md-12  col-sm-12 avi_logos avi_logos_forg">
                        <!--<img src="{{url('/')}}/img/678.jpg" class="login-img">-->
						 <img src="http://whoapp.dci.in/uploads/userimage/who-LOGO.png"  class="avi_logo" alt="logo_img" width="100px"/>
                        <div class="md_left_imgtext">
                          <!-- <p>A Sample and intelligent to-do list that makes it easy to plan your day</p>-->
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6  col-md-8  col-sm-12 md_log_right">
                     <div class="bg-white login_content login_border_radius">
                       <form action="" id="forgotpassword" method="post" class="forgotpassword">
                            <h3 class="md_helo">Hello there !</h3>
                            <p>Forgot your password ?  Start recover here</p>
                            <div class="form-group" id="email_inner">
                               <label for="email" class="col-form-label"> E-mail</label>
                               <div class="input-group">
                                  <span class="input-group-addon input_email">
                                    <i class="fa fa-envelope text-primary"></i></span>
                                  <input type="text" class="form-control  form-control-md" id="email" name="email" placeholder="E-mail">
                               </div>
                               <span class="Err"></span>
                            </div>
                            <div class="form-group">
                               <div class="row">
                                  <div class="col-6 text-right ">
                                    <input type="hidden" name="_token" id="csrftoken" value="{{ csrf_token() }}">
                                     <input type="button" value="Submit" class="btn btn-primary btn-block login_button" onclick="return validation();">
                                  </div>
                               </div>
                            </div>
                            <div class="form-group forgot_pwd">
                               <a href="{{url('/')}}/login" class="custom-control-description forgottxt_clr">Login?</a>
                            </div>
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

    <script>

    $(document).ready(function() {
      $(window).keydown(function(event){
        if( (event.keyCode == 13) && (validation() == false)) {
          event.preventDefault();
          return false;
        }
      });
    });

    function validation()
    {
        var err='';
        $('.Err').hide();
        $('.successmail').hide();
        $('.failuremail').hide();

        var email=$('#email').val().trim();
        var emailregex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if((email=='' || email==null) && err=='')
        {
            $('.Err').html("");
            $('.Err').show();
            $('.Err').append("The E-mail field is required");
            err='set';
        }
        if(email!="" && !emailregex.test(email) && err=='')
        {
            $('.Err').html("");
            $('.Err').show();
            $('.Err').append("Please provide a valid E-mail");
            err='set';
        }

        if(err!='')
        {
            $(':input[type="button"]').prop('disabled', false);
            return false;
        }
        else
        {
            checkemailexist();
        }
    }

    function checkemailexist() 
    {
        var err='';
        $('.Err').hide();
        $.ajax({
          type : "POST",
          url : "{{ url('/') }}/forgotuserexist",
          data : $('#forgotpassword').serialize(),
          beforeSend : function() {
          },
          success : function(data) { 
            if(data == "inactive")
            {
                $('.Err').html("");
                $('.Err').show();
                $('.Err').append("Your account is not activate yet.");
                return false;
            }
            else if(data == "success")
            {
                $('.Err').html("");
                $('.Err').show();
                $('.Err').append("Invalid Credentials.");
                return false;
            }
            else
            {  
                $('#forgotpassword').submit();
            }
            },
        });
    }
    </script>
   </body>
</html>
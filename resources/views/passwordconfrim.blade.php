<!DOCTYPE html>
<html>
   <head>
      <title>Donation App</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="shortcut icon" href="{{url('/')}}/img/logo1.ico"/>
      <!--Global styles -->
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/components.css" />
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/custom.css" />
      <!--End of Global styles -->
      <!--Plugin styles-->
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/bootstrap.min.css"/>
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors/wow/{{url('/')}}/css/animate.css"/>
      <!--End of Plugin styles-->
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/login.css"/>
   </head>
   <style type="text/css">
    .Err, .Err1 { display:none; color:red!important; }
   </style>
   <span id="errNm2"></span>
   <span id="errNm1"></span>
   <body style="background-color: #949609 !important; background-image: none;">
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
                     <h3 style="font-family: ;font-weight: 600; color:#949609;">
                        Donation App
                     </h3>
                  </div>
                  <div class="col-lg-12  col-md-12  col-sm-12">
                     <img src="{{url('/')}}/img/678.jpg" class="login-img">
                     <div class="md_left_imgtext">
                        <p style="font-size:13px;">A Sample and intelligent to-do list that makes it easy to plan your day</p>
                        <p>Have an accoun 
                           <a href="{{url('/')}}/login" class="custom-control-description forgottxt_clr" style="color:#949609 !important;">Login Now</a>
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6  col-md-8  col-sm-12 md_log_right">
                  <div class="bg-white login_content login_border_radius">
                     <form action="{{url('updatepassword')}}" id="resetpassword" method="post" class="login_validator">
                        <input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
                        <h3> Reset Your Password</h3>
                        @if($confirmstring == 0)
                       <p style="font-size: 16px;font-weight: bold;color: red; ">Invalid Link<p>
                       @elseif($confirmstring == 2)
                       <p style="font-size: 16px;font-weight: bold;color: red; ">Link Expired<p>
                       @else
                        <div class="form-group">
                           <label for="newpassword" class="col-form-label">New Password <span data-toggle="tooltip" id="myTooltip" class="toolset"><i class="fa fa-info"></i></span></label>
                           <div class="input-group">
                               <span class="input-group-addon input_email">
                                   <i class="fa fa-lock text-primary"></i>
                               </span>
                               <input type="password" class="form-control  form-control-md" id="newpassword" name="newpassword" placeholder="Enter New Password" >
                           </div>
                            <span class="Err"></span>
                       </div>
                        <div class="form-group">
                           <label for="repeatpassword" class="col-form-label">Repeat Password </label>
                           <div class="input-group">
                               <span class="input-group-addon input_email">
                                   <i class="fa fa-lock text-primary"></i>
                               </span>
                               <input type="password" class="form-control  form-control-md" id="repeatpassword" name="repeatpassword" placeholder="Enter Repeat Password" >
                           </div>
                            <span class="Err1"></span>
                       </div>
                       <!--</h3>-->
                       <div class="form-group"> 
                           <div class="row">
                               <div class="col-lg-12">
                                   
                               </div>
                           </div>
                       </div>
                       <input type="hidden" name="user_id" value="{{$id}}"/>
                       <div class="form-group">
                           <div class="row">
                               <div class="col-6 text-right ">
                                   <input type="button" value="Submit" class="btn btn-primary btn-block login_button" onclick="return validation();">
                               </div>
                           </div>
                       </div>
                           @endif
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script></script>
      <!-- global js -->
      <script type="text/javascript" src="{{url('/')}}/js/jquery.min.js"></script>
      <script type="text/javascript" src="{{url('/')}}/js/popper.js"></script>
      <script type="text/javascript" src="{{url('/')}}/js/bootstrap.min.js"></script>
      <!-- end of global js-->
      <!--Plugin js-->
      <script type="text/javascript" src="{{url('/')}}/vendors/bootstrapvalidator/{{url('/')}}/js/bootstrapValidator.min.js"></script>
      <script type="text/javascript" src="{{url('/')}}/vendors/wow/{{url('/')}}/js/wow.min.js"></script>
      <!--End of plugin js-->
      <script type="text/javascript" src="{{url('/')}}/js/pages/login1.js"></script>

      <script type="text/javascript">
    jQuery(document).ready(function($){
    $("#myTooltip").tooltip({
        title: "<div class='tool-list'><h5>Password Must contains</h5><ul><li> Minimum 8 characters</li><li> Must include alphanumeric characters</li><li> Atleast one special charcter</li></ul></div>",  
        html: true, 
    }); 
});
</script>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/{{url('/')}}/{{url('/')}}/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/jquery.validate.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/additional-methods.js"></script>


<script type="text/javascript">
    function validation()
    {
        var err='';
        $('.Err').hide();
        $('.Err1').hide();

        var password = $('#newpassword').val();
        var confirmpassword = $('#repeatpassword').val();

        var passregex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/; 
        
        if((password=='' || password==null))
        {
            $('.Err').html("");
            $('.Err').show();
            $('.Err').append("New Password field is required");
            err='set';
        }
        if(password!="" && !passregex.test(password))
        {
            $('.Err').html("");
            $('.Err').show();
            $('.Err').append("Password is Invalid");
            err='set';
        }
        if((confirmpassword=='' || confirmpassword==null))
        {
            $('.Err1').html("");
            $('.Err1').show();
            $('.Err1').append("Confirm Password field is required");
            err='set';
        }
        if(confirmpassword!="" && confirmpassword!=password && password!="")
        {
            $('.Err1').html("");
            $('.Err1').show();
            $('.Err1').append("Confirm Password does not match with New Password");
            err='set';
        }

        if(err!='')
        {
            $(':input[type="button"]').prop('disabled', false);
            return false;
        }
        else
        {
           $('#resetpassword').submit();
        }           
    }
</script>
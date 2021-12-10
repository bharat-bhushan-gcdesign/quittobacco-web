
<!DOCTYPE html>
<html>
<head>
    @if($type == 1)
      <title>Success</title>
    @else
      <title>Failure</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Global styles -->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/components.css" />
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/custom.css" />
    <!--End of Global styles -->
    <!--Plugin styles-->
    <!-- <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors/bootstrapvalidator/{{url('/')}}/css/bootstrapValidator.min.css"/> -->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/vendors/wow/css/animate.css"/>
    <!--End of Plugin styles-->
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/login1.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/pages/wizards.css"/>
    <link type="text/css" rel="stylesheet" href="{{url('/')}}/css/style.css" />
</head>
<style type="text/css">
 .row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}


.md_totlog {
    width: 100%;
    display: inline-block;
    float: left;
    -ms-flex: 0 0 83%;
    flex: 0 0 83%;
    max-width: 83%;
    background-color: #fff;
    border-radius: 20px;
    padding: 20px 0px;
}


.md_log_left {
    display: inline-block;
    float: left;
    width: 100%;
    padding: 0px 50px;
    text-align: left;
}


.md_log_right {
    display: inline-block;
    float: left;
    width: 100%;
    padding: 0px;
    text-align: left;
}


.login_logo {
    padding-bottom: 5px;
    background-color: rgba(255, 255, 255, 0.2);
}

.login_border_radius1 {
    border-radius: 5px 5px 0 0;
}


.login_top_bottom {
    margin: 3% 0;
}


h3.md_logos {
    font-size: 40px;
    font-weight: bold;
    color: #1d5b99;
    padding-left: 20px;
    padding-top: 10px;
}


.md_rsleft {
    text-align: center;
}


.md_rsleft img {
    width: 60%;
}



.md_log_right {
    display: inline-block;
    float: left;
    width: 100%;
    padding: 0px;
    text-align: left;
}

.md_rsright h3.md_helo {
    font-size: 40px;
    font-weight: bold;
    padding-top: 30px;
}


.md_rsright img {
    width: 100px;
    margin: 35px;
    text-align: center;
    display: inline-block;
}

.md_rsleft-f img {
    width: 100%;
}

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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 login_top_bottom">
            <div class="row">
                <div class="col-lg-12  col-md-8  col-sm-12 mx-auto md_totlog">
                    <div class="col-lg-6  col-md-8  col-sm-12 md_log_left">
                        <div class="login_logo login_border_radius1"> 
                            <h3 class="md_logos"> 
                                WHO App
                            </h3>
                        </div>
                        @if($type == 1)
                          <div class="col-lg-12  col-md-12  col-sm-12 md_rsleft"> 
                          <img src="{{url('/')}}/img/men3.png">
                        @else
                          <div class="col-lg-12  col-md-12  col-sm-12 md_rsleft-f">
                            <img src="{{url('/')}}/img/men4.jpg">
                          @endif
                        </div>
                    </div>
                    
                    <div class="col-lg-6  col-md-8  col-sm-12 md_log_right md_rsright">
                      <?php echo $message; ?>
                       @if($type == 1)
                         <a href="{{url('/')}}" class="btn btn-primary" style="border-radius: 8px;padding: 10px 12px;background-color: #1d5b99!important;color: #fff;border:none;font-size: 15px;text-decoration: none;">Login</a>
                        @else
                          <a href="{{url('/')}}" class="btn btn-primary" style="border-radius: 20px; padding: 10px 12px;background-color: #1d5b99!important;color: #fff;border:none;font-size: 15px; text-decoration: none;">Go back </a>
                          @endif
                      
                      <!-- Visit <a href="{{url('/')}}" class="btn btn-primary">Home</a> -->
                    </div>
                        </div>
                    </div>
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
<script type="text/javascript" src="{{url('/')}}/vendors/bootstrapvalidator/{{url('/')}}/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/vendors/twitter-bootstrap-wizard/{{url('/')}}/js/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/vendors/wow/{{url('/')}}/js/wow.min.js"></script>
<!--End of plugin js-->
<script type="text/javascript" src="{{url('/')}}/js/pages/login1.js"></script>
<script type="text/javascript" src="{{url('/')}}/js/pages/wizard.js"></script>
</body>

</html>
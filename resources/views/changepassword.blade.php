@include('header')
@include('sidebar')

<!-- /#left -->
<head>
    <style type="text/css">
        .error {
            color: red;
        }
    </style>
</head>
<!-- /#left -->
<div class="wrapper">
   <!-- /#left -->
   <div id="content" class="bg-container">
      <header class="head">
         <div class="main-bar">
            <div class="row no-gutters">
               <div class="col-sm-5 col-lg-6 skin_txt">
                  <h4 class="nav_top_align">
                      Change Password
                  </h4>
               </div>
               <div class="col-sm-7 col-lg-6">
                  <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                     <li class="breadcrumb-item">
                         <a href="{{url('/')}}">
                        <i class="fa fa-home" data-pack="default" data-tags=""></i>
                        Dashboard
                        </a>
                     </li>
                  </ol>
               </div>
            </div>
         </div>
      </header>
         <style type="text/css">
    .Err, .Err1 { display:none; color:red!important; }
    .successmsg {
   color: #fff !important;
   background-color: green !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
}
.errmsg {
  color: #fff !important;
   background-color: #ff8086 !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
}
.resulttN.result_hover {
    font-size: 13px;
    background: #ED7626;
    line-height: 24px;
    color: #fff;
    padding: 10px;
    position: relative;
    display: block !Important;
    position: absolute;
    bottom: 110%;
}
.resulttN.result_hover:before {
    position: absolute;
    left: 30%;
    bottom: -14px;
    content: '\f0d7';
    font-family: fontawesome;
    color: #ED7626;
    font-size: 20px;
}
.error {
            color: red;
        }
 
   </style>
       <div align="center">
      @if(Session::has('message'))
       <h4>
      <p class="alert alert-danger errmsg">{{ Session::get('message') }}</p>
      </h4>
      @endif
      
      @if (count($errors) > 0)                                  
      <h4>
         @foreach ($errors->all() as $error)
         <p class="alert alert-info successmsg">{{ $error }}</p>
         @endforeach
      </h4>
      @endif
   </div>
      <div class="outer">
          <form action="{{url('update-password')}}" method="post" id="myforms" name="myform">
         <div class="inner bg-container forms">
            <div class="row">
               <div class="col">
                  <div class="card">
                     <div class="card-body">
                     	 <div class="row" align="center">
                           <div class="col-sm-12 input_field_sections">
                            	 <span style="color:red"><b> ** Password must contain 8 characters, Atleast one alphanumeric character, Atleast one special charcter **</span>

							</div>
							</div>

                        <div class="row" align="right">
                            <div class="col-sm-4 input_field_sections">
                              <h5>Old Password</h5>
                           </div>
                           <div class="col-sm-8 input_field_sections">
                               <input class="form-control input-height" name="old_password" type="text" id="old_password" value="" required="" placeholder="Enter old password here.." >
                           </div>
                        </div>
                         <div class="row" align="right">
                           <div class="col-sm-4 input_field_sections">
                              <h5>New Password <i class="fa fa-info resultt"></i>
                              <span class="resulttN" style="display:none;"><b>Password must contain</b><br> * 8 characters,<Br>* Atleast one alphanumeric character, <br>* Atleast one special charcter</span>
                              </h5> 
                             
                           </div>
                         <div class="col-sm-8 input_field_sections">
                              
                               <input type="password" class="form-control" name="newpassword" id="newpassword" value="" />

                                <span class="Err"></span>
                           </div>
                        </div>
                        <div class="row" align="right">
                           
                           <div class="col-sm-4 input_field_sections">
                              <h5>Confirm Password</h5>
                           </div>
                           <div class="col-sm-8 input_field_sections">
                               <input type="password" class="form-control" name="repeatpassword" id="repeatpassword" value="" />
                                <span class="Err1"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.row -->
            <div class=" m-t-35">
               <div class="form-actions form-group row">
                  <div class="col-xl-12 text-center">
                     <input type="hidden" name="_token" value="{{csrf_token()}}">
                     <input type="button" value="Submit" class="btn btn-primary" onclick="return validation();">
                     <input type="button" class="btn btn-default" value="Cancel" id="cancelform">
                  </div>
               </div>
            </div>
         </div>
       </form>
         <!-- /.outer -->
      </div>
   </div>
   <!-- /#content -->
</div>
<!-- startsec End -->




<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/jquery.validate.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/additional-methods.js"></script>
      <script type="text/javascript" src="{{url('/')}}/js/popper.js"></script>
      <script type="text/javascript" src="{{url('/')}}/js/bootstrap.min.js"></script>

<script type="text/javascript">

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    $("#myTooltip").tooltip({

        title: "<div class='tool-list'><h5>Password Must contains</h5><ul><li>Should have 8 characters</li><li>Must contain alphabets</li><li>Must have one special charcter</li></ul></div>",  
        html: true, 
    }); 
  });
</script>

<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
    @include('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        
        $("#myforms").validate({
            rules: {
                old_password: {
                    remote: {
                        url: "/check-password",
                        type: "post",
                        data: {
                            old_password: function() {
                                return $( "#old_password" ).val();
                            },
                            
                          
                            _token: function() {
                                return "{{csrf_token()}}"
                            }
                        }
                    }
                }, 
            },
            messages: {
                old_password: {
                    required: "Please Enter Old Passwod",
                    noSpace: "Please Enter valid Old Passwod.",
                    remote: "Old Passwod is Wrong",
                },
                
            },
            submitHandler: function(form){
                console.log(1)
                $('form input[type=submit]').prop('disabled', true);
                form.submit();
            },
            
        });  
    })
   
</script>


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
            $('.Err').append("Weak Password!! Your password must contain Atleast 1 numeric, 1 Alphabet and 1 Special Charecter");
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
           $('#myforms').submit();
        }           
    }
</script>
<script type="text/javascript">
   
   $(document).ready(function(){
   setTimeout(function () {
    $(".errmsg").hide()
   }, 5000); 

   setTimeout(function () {
    $(".successmsg").hide()
   }, 5000);
   
   $(".resultt").hover(function () {
    $('.resulttN').toggleClass("result_hover");
});

});

  $("#cancelform").click(function() {
   window.location.href = "{{url('/')}}";
}); 
</script>
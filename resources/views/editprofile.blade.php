@include('header')
<!-- /#left -->
<div class="wrapper">
  <style type="text/css">
    .Err, .Err1, .Err2 { display:none; color:red!important; }
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
  </style>
   @include('sidebar')
   <!-- /#left -->
   <div id="content" class="bg-container">
      <header class="head">
         <div class="main-bar">
            <div class="row no-gutters">
               <div class="col-sm-5 col-lg-6 skin_txt">
                  <h4 class="nav_top_align">
                     <i class="fa fa-plus"></i>
                     Update Profile
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
      <div align="center">
      @if(Session::has('message'))
       <h4>
      <p class="alert alert-info successmsg">{{ Session::get('message') }}</p>
      </h4>
      @endif
      
      @if (count($errors) > 0)                                  
      <h4>
         @foreach ($errors->all() as $error)
         <p class="alert alert-danger errmsg ">{{ $error }}</p>
         @endforeach
      </h4>
      @endif
   </div>
        <div class="outer">
            <form action="{{url('saveprofile')}}" method="post" id="myforms" name="myform" enctype="multipart/form-data">
                <div class="inner bg-container forms">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 input_field_sections">
                                          <h5>Username</h5>
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name', isset($adminuserdetail->name) ? $adminuserdetail->name : null) }}" maxlength="30" />
                                        </div>
                                            <div class="col-sm-6 input_field_sections">
                                                <h5>Email</h5>
                                                @if($id==0)
                                                   <input type="text" class="form-control" name="email" id="email" value="{{old('email', isset($adminuserdetail->email) ? $adminuserdetail->email : null) }}" />
                                                @else
                                                   <input type="text" class="form-control" name="email" id="email" value="{{$adminuserdetail->email}}" disabled />
                                                @endif
                                           </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-sm-6 input_field_sections">
                                            <h5>Select Image</h5>                           
                                                <input type="file" name="profile_image" id="Document" value="{{ old('adminuserdetail', isset($adminuserdetail->profile->name) ? $adminuserdetail->profile->name : null) }}" />
                                                {!! $errors->first('Document', '<p class="help-block">:message</p>') !!}
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
                             <input type="hidden" name="code" id="pid" value="{{$code}}">
                             <input type="hidden" name="imgerror" id="imgerror" value="0">
                             <input type="hidden" name="_token" value="{{csrf_token()}}">
                             <input type="submit" class="btn btn-primary" value="Submit">
                             <input type="button" class="btn btn-default" value="Cancel" id="cancelform">
                          </div>
                       </div>
                    </div>
                </div>
            </form>
         <!-- /.outer -->
         <div class="modal fade" id="search_modal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <form>
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span class="float-right" aria-hidden="true">&times;</span>
                     </button>
                     <div class="input-group search_bar_small">
                        <input type="text" class="form-control" placeholder="Search..." name="search">
                        <span class="input-group-btn">
                        <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <!-- /#content -->
</div>
<!-- startsec End -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"
   type="text/javascript"></script>
@include('footer')
<style type="text/css">
   body
   {
   font-family: Arial, Sans-serif;
   }
   .error
   {
   color:red;
   font-family:verdana, Helvetica;
   }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script type="text/javascript">

  function readURL(input) {
    if (input.files && input.files[0]) {
       var file = input.files[0];
       var fileType = file["type"];
       var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
       if ($.inArray(fileType, validImageTypes) != -1) {
         var reader = new FileReader();
         reader.onload = function (e) {
           $("#imgerror").val(0);
           $('#profile-img-tag').show();
           $('#profile-img-tag').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
      }
      else
      {
        $("#imgerror").val(1);
        $('#profile-img-tag').hide();
      }
    }
 }

$(document).ready(function(){

   $.validator.addMethod("lettersonly", function(value, element) {
     return this.optional(element) || /^[a-zA-Z\s ]+$/i.test(value);
   }, "Alpha Numeric characters only allowed."); 

   $.validator.addMethod("phonenumber", function(value, element) {
      return this.optional(element) || /^[0-9-_]+$/i.test(value);
   }, "VAlid Phone number only allowed."); 

  $.validator.addMethod("imagevalidation", function(value, element) {
    var hiddenimage = $("#imgerror").val();
      return this.optional(element) || hiddenimage==0;
   }, "Invalid Profile Image"); 
 
});
</script>
<script type="text/javascript">
$(function()
{
  $("#myforms").validate(
  {
      onfocusout: false,
      invalidHandler: function(form, validator) {
      var errors = validator.numberOfInvalids();
      if (errors) {
           validator.errorList[0].element.focus();
      }
    },
    rules:{
      name: {
        required:true,
        lettersonly:true,
        minlength: 3,
        maxlength:30
      },
      phone: {
        required:true,
        phonenumber:true,
        minlength: 8,
        maxlength:16 
      },
      email: {
        required:true,
        email:true,
        remote:{
            url : "{{ url('/') }}/adminuserexist",
            type: 'GET',
            data :{ 
             id: $('#pid').val(),
             email: this.value,
            },
            complete: function(data) {
                   //console.log(data);
            }
         }
      },
      dob: {
        required:true,
        date:true,
      },
      profileimg: {
        imagevalidation: true,
      },
    },
    messages:{
      name:{
        required:"User Name Field is required",
        lettersonly:"User Name Field is invalid",
      },
      phone:{
        required:"Phone Number Field is required",
        phonenumber:"Phone Number Field is invalid",
      },
      email:{
        required:"Email Field is required",
        email:"Email Field is invalid",
        remote:"This email is already exist",

      },
      dob:{
        required:"Dob Field is required",
        date:"Dob Field is invalid",
      }, 
      profileimg:{
        imagevalidation:"Profile Image Field is invalid",
      },        
    },
  });   

});


//fileupload
$( function() {
    $("#Document").fileinput({
            "overwriteInitial":true,
            "initialPreviewAsData":true,
            @if(isset($adminuserdetail->profile) && $adminuserdetail->profile != '')
                "initialPreview": '{{url('/')}}/uploads/files/{{$adminuserdetail->profile->name}}',
                "initialPreviewConfig": [{
                    "caption":"{{$adminuserdetail->profile->name}}",
                }],
            @endif
            "showRemove":false,
            "showUpload":false,
            //"uploadUrl":  "#",
            //"uploadAsync": false,

            //"deleteUrl":"{!! url('/').'/home/deleteimage' !!}",
            "allowedFileExtensions": ['jpeg', 'jpg', 'png', 'JPEG'],
            "deleteExtraData":{"MediaFilesPath":"_file_del_","_file_del_":"","_token":"{{ csrf_token() }}","_method":"GET","id":"{!! isset($adminuserdetail->id)?$adminuserdetail->id:'' !!}" }
    })
});

$("#cancelform").click(function() {
   window.location.href = "{{url('/')}}";
}); 

var dt = new Date();
dt.setFullYear(new Date().getFullYear()-18);

$('#userdob').datepicker({
  viewMode: "years",
   endDate : dt,
});

$(document).ready(function(){

   setTimeout(function () {
      $(".errmsg").hide()
     }, 5000); 

     setTimeout(function () {
      $(".successmsg").hide()
     }, 5000);
});
</script>
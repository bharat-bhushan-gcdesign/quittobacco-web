@include('header')
@include('sidebar')
<style>
   .error {
   color: red;
   }
   .fileinput.fileinput-new { margin-bottom: 0px;  }
   .fileinput.fileinput-new .btn.btn-file {     overflow: visible;  width: 185px; position: relative; top:-15px; }
   .fileinput.fileinput-new .m-t-20  { margin-top: 0px;   }
   .fileinput.fileinput-new #profile-img-error {     position: absolute;
   top: 30px;
   left: 0; }
</style>
<div id="content" class="bg-container">
   <header class="head">
      <div class="main-bar">
         <div class="row no-gutters">
            <div class="col-sm-5 col-lg-6 skin_txt">
               <h4 class="nav_top_align">
                  <i class="fa fa-plus"></i>
                   @if($pid=="")
                    Add User
                   @else
                    Update User
                   @endif
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
                  <li class="breadcrumb-item">
                     <a href="/users">Users</a>
                  </li>
               </ol>
            </div>
         </div>
      </div>
   </header>
   <div class="outer">
    @if($pid=="")
    <form method="POST" action="{{url('user/saveuser')}}" id="userforms" name="edit_country" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
    @else
    <form method="POST" action="{{url('user/saveuser')}}" id="edituserforms" name="edit_country" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
    @endif
    {{ csrf_field() }}
      <div class="inner bg-container forms">
         <div class="row">
            <div class="col">
               <div class="card">
                 <div class="card-body">
                    <div class="row">
                       <div class="col-sm-6 input_field_sections">
                          <h5>First Name</h5>
                          <input type="text" class="form-control" name="first_name"  value="{{ old('first_name', isset($users->firstName) ? $users->firstName : null) }}" id="first_name" maxlength="30"  />
                       </div>
                       <div class="col-sm-6 input_field_sections">
                          <h5>Last Name</h5>
                          <input type="text" class="form-control" name="last_name"  value="{{ old('last_name', isset($users->lastName) ? $users->lastName : null) }}" id="last_name" maxlength="30" />  
                       </div>
                    </div>
                    <div class="row">
						 <div class="col-sm-6 input_field_sections">
                          <h5>Email</h5>
                          <input type="email" class="form-control"  name="email"  value="{{ old('email', isset($users->email) ? $users->email : null) }}" id="email" maxlength="50" />  
                       </div>
                       <div class="col-sm-6 input_field_sections">
                          <h5>Mobile No</h5>
                          <input type="text" class="form-control" name="ph_no"  value="{{ old('mobile', isset($users->mobile) ? $users->mobile : null) }}" id="ph_no" maxlength="16"  />
                       </div>
                       
                    </div>
                  
                    <div class="row">
                       <div class="col-sm-6 input_field_sections">
                          <h5>Status</h5>
                          <select class="form-control"  name="status"  value="" id="status">
                             <option value="1">Active</option>
                             <option value="0" {{ (isset($users->status) && $users->status==0)  ? 'selected': '' }}>Ban</option>
                          </select>
                       </div>
                      
                    </div>
                    <div class="row">
                       <div class="form-group  m-t-15 col-sm-6">
                          <div class="col-12 col-lg-12 text-center text-lg-left">
                             <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new  text-center" style="padding-top: 20px; " >
                                   @if(isset($users) && $users->profile_image!="" && $users->profile_image!=null)
                                   <img src="{{url('/')}}/uploads/userimage/{{$users->profile_image}}" id="profile-img-tag" width="180px" height="140px"  name="profile_imaged" style="margin-top:15px;"/>
                                   @else
                                   <img src="{{url('/')}}/uploads/dummy/userdefault.png" id="profile-img-tag" width="180px" height="140px" name="profile_imaged" />
                                   @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists img-thumbnail"></div>
                                <div class="m-t-20 text-center">
                                   <span class="btn btn-primary btn-file">
                                   <span>Select image</span>
                                   <span class="fileinput-exists">Change</span>
                                   <input type="file" name="profile_img" id="profile_img" class="fileinput-new" onchange="readURL(this);"  value="" accept="image/x-png,image/jpeg">
                                   </span>
                                   <a href="#" class="btn btn-warning fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                             </div>
                          </div>
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
                   <input type="hidden" value="{{$pid}}" name="pid" id="pid">
                   <input type="submit" class="btn btn-primary" value="Submit">
                   <input type="button" class="btn btn-default" value="Cancel" id="cancelform">
                </div>
              </div>
             </div>
          </div>
       </div>
     </form>
    </div>
<!-- /#content -->
</div>
<!-- startsec End -->
@include('footer')
<!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"
   type="text/javascript"></script> -->
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"
   type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<script language="javascript">
   function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $('#profile-img-tag').show();
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
$("#userforms").bind("submit", function() { 

var ext = $('#profile_img').val().split('.').pop().toLowerCase();
if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alert('invalid extension!');
}

});
   
    jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "<span class='testing' style='color:red'>  Please enter only letters</span>");
   
    jQuery.validator.addMethod("email", function(value, element) {
    return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "<span class='testing' style='color:red'>  Please enter Valid email</span>");
    $('input, text').blur(function() {
        var value = $.trim( $(this).val() );
         $(this).val( value );
    });
   $(function() {
   
    $( "#userforms" ).validate({
       rules: {
                first_name: {
                    required: true,
                    lettersonly:true,
                     minlength: 3,
                     maxlength:50
                 },  
                 last_name: {
                     required: true,
                     lettersonly:true,
                     minlength: 1,
                     maxlength:50
                }, 
                ph_no: {
                     required: true,
                     number:true,
                    minlength: 8,
                     maxlength:16
                }, 
               

                email: {
                  required: true,
                  email:true,
                    remote:{
                             url : "{{ url('/') }}/userexist",
                             type: 'GET',
                             data :{ 
                              id: $('#pid').val(),
                              email: this.value,
                            },
                            complete: function(data) {
                                    //console.log(data);
                            }
                          },
                }, 
                 profile_img: {
                      required: true,
                          accept: "image/*"
                    }
        },
       messages: {
                     first_name: {
                        required: "FirstName is required",
                            }, 
                    last_name: {
                         required: "LastName is required",
                             },
                    ph_no: {
                         required: "MobileNumber is required",
                    number:"MobileNumber Accepts Only Numbers",
                             },
                  
                       email:{
                           required: "Email is required",
                            
                            remote:"This email is already exist",
                       }, 
                       profile_img: {
                             required: "Please upload file.",
                             accept: "Please upload file in these format only (jpg, jpeg, png)."
                         }
                     
                    },
           submitHandler: function(form){
           $('form input[type=submit]').prop('disabled', true);
             form.submit();
         },
    });  
    });
   
   
   // $(function() {
   
   // $( "#edituserforms" ).validate({
   //     rules: {
   //              first_name: {
   //                  required: true,
   //                  lettersonly:true,
   //                  minlength: 3,
   //                  maxlength:20
   //              },  
   //              last_name: {
   //                  required: true,
   //                  lettersonly:true,
   //                  minlength: 1,
   //                  maxlength:20
   //             }, 
   //             ph_no: {
   //                  required: true,
   //                  number:true,
   //                  minlength: 8,
   //                  maxlength:16
   //             }, 
   //             alt_no: {
   //                  number:true,
   //                  minlength: 8,
   //                  maxlength:16
   //             },    
   //             gender: {
   //                required: true,
   //             },
   //             dob: {
   //                required: true,
   //             },  
   //             email: {
   //                required: true,
   //                email:true,
   //                 remote:{
   //                          url : "{{ url('/') }}/userexist",
   //                          type: 'GET',
   //                          data :{ 
   //                           id: $('#pid').val(),
   //                           email: this.value,
   //                          },
   //                          complete: function(data) {
   //                                 //console.log(data);
   //                          }
   //                       }
   //             }, 
   //              profile_img: {
   //                        accept: "image/*"
   //                  }
   //      },
   //     messages: {
   //                  first_name: {
   //                      required: "FirstName is required",
   //                           }, 
   //                  last_name: {
   //                      required: "LastName is required",
   //                           },
   //                  ph_no: {
   //                      required: "MobileNumber is required",
   //                      number:"MobileNumber Accepts Only Numbers",
   //                           },
   //                  gender: {
   //                      required: "Gender is required",
   //                          },
   //                    dob: {
   //                      required: "Date of Birth is required",
   //                          },
   //                    email:{
   //                         required: "Email is required",
   //                         remote:"This email is already exist",
   //                    }, 
   //                    profile_img: {
   //                          accept: "Please upload file in these format only (jpg, jpeg, png)."
   //                      }
                     
   //                 },
   //                 submitHandler: function(form){
   //                      $('form input[type=submit]').prop('disabled', true);
   //                    form.submit();  
   //                  },
   // });  
   // });
   var dt = new Date();
   dt.setFullYear(new Date().getFullYear()-18);
   var tt = new Date();
   tt.setFullYear(new Date().getFullYear()-58);
   
   jQuery(document).ready(function($) {
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
             maxDate: tt,
             endDate : dt,
              startDate: '-18250d'
            
        });
    });
   
   
   $("#cancelform").click(function() {
   window.location.href = "{{url('/users')}}";
   }); 
</script>

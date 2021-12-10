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
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-sm-5 col-lg-6 skin_txt">
                    <h4 class="nav_top_align">
                        <i class="fa fa-plus"></i>
                            @if(isset($user))
                                Edit User
                            @else
                                Add User
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
                            <a href="{{ route('users.create') }}">User</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($user))
                    <form method="POST" id="userforms" name="user" action="{{ route('users.update',['user'=>$user->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                @else
                    <form method="POST" action="{{ route('users.store') }}" accept-charset="UTF-8" id="userforms" name="user" class="form-horizontal" enctype="multipart/form-data">
                @endif
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>First Name</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="name" type="text" id="name" value="{{ old('user', isset($user->name) ? $user->name : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter user name here.." >
                                                     
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Mobile Number</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="mobile" type="text" id="mobile" value="{{ old('user', isset($user->mobile) ? $user->mobile : null) }}" minlength="10" maxlength="10" required="" pattern="[0-9]"placeholder="Enter user Mobile Number here.." >
                                                     
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Email</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="email" type="email" id="email" value="{{ old('user', isset($user->email) ? $user->email : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter user Email here.." >
                                                     
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select User Type</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">              
                                               <select class="form-control select2 input-height" id="role" name="role" required="true">
                                                    <option value="">Select User Type</option>
                                                    <option value="2" {{ (isset($user) && $user->role==2)  ? 'selected': '' }} >Guest</option>
                                                    <option value="3" {{ (isset($user) && $user->role==3)  ? 'selected': '' }}  >Registerd</option>
                                                    <option value="4" {{ (isset($user) && $user->role==4)  ? 'selected': '' }}  >Subscribed</option>
                                                    <option value="0" {{ (isset($user) && $user->role==0)  ? 'selected': '' }} >Blocked</option>
                                                    <option value="5" {{ (isset($user) && $user->role==5)  ? 'selected': '' }} >Other</option>

                                                </select>
                                                     
                                            </div>
                                        </div>
                                         <div class="row"> 
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Status</h5>
                                            </div>
                                            <div class="col-sm-9 input_field_sections">
                                                <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                                    <option value="1">Active</option>
                                                    <option value="0" {{ (isset($user->status) && $user->status==0)  ? 'selected': '' }}>InActive</option>
                                                </select>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select Profile Image</h5>
                                            </div>
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <div data-provides="fileinput">
                                                    @if(isset($user) && $user->profile!=null)
                                                        <img src="{{url('/')}}/uploads/files/{{$user->profile->name}}" id="user-img-tag" width="50%" height="50%" name="user_file" />
                                                    @else
                                                        <img src="{{url('/')}}/defaults/upload.webp" id="user-img-tag" width="50%" height="50%" name="user_file" />
                                                    @endif
                                                        <div class="customfile_btntypenew">
                                                            <div class="btn btn-primary btn-file" style="width: 50%;">
                                                           <h5 style="margin: 5px 0px;color: #fff;">Upload</h5>
                                                            @if(isset($user) && $user->profile!=null)
                                                                <input type="file" name="user_file" id="user_img" class="fileinput-new" onchange="readURL(this);"  value="{{$user->profile->name}}" accept="image/x-png,image/jpeg,image/jpg">
                                                            @else
                                                                <input type="file" required name="user_file" id="user_img" class="fileinput-new" onchange="readURL(this);"  value="{{url('/')}}/defaults/upload.webp" accept="image/x-png,image/jpeg,image/jpg">
                                                            @endif

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
                                    
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                    <input type="button" class="btn btn-default" value="Cancel" id="cancelform">
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
            <!-- /.outer -->
        </div>
    </div>
    <!-- /#content -->
</div>
<!-- startsec End -->

<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
    @include('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        jQuery.validator.addMethod("noSpace", function(value, element) { 
            return value == '' || value.trim().length != 0;  
        },"No space please and don't leave it empty");

        jQuery.validator.addMethod("letterswithspace", function(value, element) {
            return this.optional(element) || /^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/.test(value);
        },"letters only");

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /[A-Za-z]+(\s[A-Za-z]+)?/.test(value);
        },"<span class='testing' style='color:red'>  Please enter only letters</span>");

        // jQuery.validator.addMethod("lettersonly", function(value, element) {
        //     return this.optional(element) || /^[a-z]+$/i.test(value);
        // }, "Letters only please"); 

        $("#userforms").validate({

            rules: {
                mobile: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                    remote: {
                        url: "/users/check-exist",
                        type: "post",
                        data: {
                            id: function() {
                                return $( "#id" ).val();
                            },
                            mobile: function() {
                                return $( "#mobile" ).val();
                            },
                            _token: function() {
                                return "{{csrf_token()}}"
                            }
                        }
                    }
                }, 
                email: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                    remote: {
                        url: "/users/check-exist",
                        type: "post",
                        data: {
                            id: function() {
                                return $( "#id" ).val();
                            },
                            email: function() {
                                return $( "#email" ).val();
                            },
                            _token: function() {
                                return "{{csrf_token()}}"
                            }
                        }
                    }
                }, 
                description: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                }, 
            },
            messages: {
                title: {
                    required: "Please Enter User Title",
                    noSpace: "Please Enter valid Title.",
                    remote: "Title Already Exists!",
                },
                description: {
                    required: "Please Enter Description",
                    noSpace: "Please Enter valid Description.",
                    remote: "Description Already Exists!",
                }
            },
            submitHandler: function(form){
                console.log(1)
                $('form input[type=submit]').prop('disabled', true);
                form.submit();
            },
        });
    })
    $("#cancelform").click(function() {
        window.location.href = "{{url('/users')}}";
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var fileType = file["type"];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
            if ($.inArray(fileType, validImageTypes) != -1) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#imgerror").val(0);
                    $('#user-img-tag').show();
                    $('#user-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                $("#imgerror").val(1);
                $('#user-img-tag').hide();
            }
        }
    }
</script>
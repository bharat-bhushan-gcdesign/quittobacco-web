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
                            @if(isset($static_notification))
                                Edit Notification
                            @else
                                Add Notification
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
                            <a href="{{ route('static_notifications.create') }}">Notification</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div align="center">
        @if (Session::has('success_message'))
            <h4>
                <p class="alert alert-info successmsg">{{ Session::get('success_message') }}</p>
            </h4>
        @endif
        @if (count($errors) > 0)                                  
            <h4>
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger errmsg">{{ $error }}</p>
                @endforeach
            </h4>
        @endif
    </div>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                    @if(isset($static_notification))
                    
                        <form method="POST" action="{{ route('static_notifications.update',['static_notification'=>$static_notification->code]) }}" accept-charset="UTF-8" id="learningforms" name="learning" class="form-horizontal" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ route('static_notifications.store') }}" accept-charset="UTF-8" id="learningforms" name="learning" class="form-horizontal" enctype="multipart/form-data">
                    @endif

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                       
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Message</h5>
                                            </div>    
                                                <input class="form-control input-height" name="message"  id="message" value="{{ old('static_notification', isset($static_notification) ? $static_notification->message : null) }}"  required="" >
                                                </input>     
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
      <link type="text/css" rel="stylesheet" href="{{url('/')}}/fileinput/fileinput.min.css">
<script type="text/javascript" src="{{url('/')}}/fileinput/fileinput.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
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


        $("#learningforms").validate({

            rules: {
            
                message: {
                    noSpace:true,
                },    
                users: {
                    required:true,
                }, 
           
            },
            messages: {
                message: {
                    required: "Please Enter Message",
                    noSpace: "Please Enter valid Description.",
                },
            },
            submitHandler: function(form){
                console.log(1)
                $('form input[type=submit]').prop('disabled', true);
                form.submit();
            },
             debug: true
        });
    })
    $("#cancelform").click(function() {
        window.location.href = "{{url('/static-notifications')}}";
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
                    $('#learning-img-tag').show();
                    $('#learning-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                $("#imgerror").val(1);
                $('#learning-img-tag').hide();
            }
        }
    }
   


    $(document).ready(function() {
    $('#users').select2();
});
</script>
<link type="text/css" rel="stylesheet" href="https://v2.edukool.com/assets/plugins/fileinput/fileinput.min.css">
<script type="text/javascript" src="https://v2.edukool.com/assets/plugins/fileinput/fileinput.min.js"></script>
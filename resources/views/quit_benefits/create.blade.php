@include('header')
@include('sidebar')

<!-- /#left -->

<head>
    <style type="text/css">
        .error {
            color: red;
        }
        #sample_6 tr td:nth-child(4):before, #sample_6 tr td:nth-child(4):after{
           display:none;
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
                            @if(isset($quit_benefit))
                                Edit Quit Benefit
                            @else
                                Add Quit Benefit
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
                            <a href="{{ route('quit_benefits.index') }}">Quit Benefit</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
     <div align="center">
        @if (Session::has('message'))
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
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($quit_benefit))
                    <form method="POST" id="quit_benefitforms" name="quit_benefit" action="{{ route('quit_benefits.update',['quit_benefit'=>$quit_benefit->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$quit_benefit->id}}">
                @else
                    <form method="POST" action="{{ route('quit_benefits.store') }}" accept-charset="UTF-8" id="quit_benefitforms" name="quit_benefit" class="form-horizontal" enctype="multipart/form-data">
                @endif
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Title</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="title" type="text" id="title" value="{{ old('quit_benefit', isset($quit_benefit->title) ? $quit_benefit->title : null) }}" minlength="1" maxlength="30" required="" placeholder="Enter title here.." >
                                                     
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Description</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">
                                                <textarea rows="4" cols="50" class="form-control input-height" name="description" id="description" minlength="1" required placeholder="Enter Description here.." style="resize: none;">{{ old('quit_benefit', isset($quit_benefit->description) ? $quit_benefit->description : null) }}</textarea>                
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select Image</h5>     
                                            </div> 
                                            <div class="col-sm-9 input_field_sections">
                                                <input type="file" name="quit_benefit_file" id="Document" value="{{ old('quit_benefit', isset($quit_benefit->file->name) ? $quit_benefit->file->name : null) }}" />
                                                {!! $errors->first('Document', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                       
                                      
                                        <div class="row"> 
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Status</h5>
                                            </div>
                                            <div class="col-sm-9 input_field_sections">
                                                <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                                    <option value="1">Active</option>
                                                    <option value="0" {{ (isset($quit_benefit->status) && $quit_benefit->status==0)  ? 'selected': '' }}>InActive</option>
                                                </select>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>  
<script type="text/javascript">
    $(document).ready(function(){

        jQuery.validator.addMethod("noSpace", function(value, element) { 
            return value == '' || value.trim().length != 0;  
        },"No space please and don't leave it empty");

        jQuery.validator.addMethod("letterswithspace", function(value, element) {
            return this.optional(element) || /^[a-z|A-Z|0-9]+(?: [a-z|A-Z|0-9]+)*$/.test(value);
        },"letters only");

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /[A-za-z0–9_]+(\s[A-Za-z0-9]+)?/.test(value);
        },"<span class='testing' style='color:red'>  Please enter only letters</span>");

        // jQuery.validator.addMethod("lettersonly", function(value, element) {
        //     return this.optional(element) || /^[a-z]+$/i.test(value);
        // }, "Letters only please"); 

        $("#quit_benefitforms").validate({

            rules: {
                title: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    remote: {
                        url: "/quit-benefits/check-exist",
                        type: "post",
                        data: {
                            id: function() {
                                return $( "#id" ).val();
                            },
                            title: function() {
                                return $( "#title" ).val();
                            },
                            _token: function() {
                                return "{{csrf_token()}}"
                            }
                        }
                    }
                }, 
               
               
            },
            messages: {
                title: {
                    required: "Please Enter Quit Benefit Title",
                    noSpace: "Please Enter valid Title.",
                    remote: "Title Already Exists!",
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
        window.location.href = "{{url('/quit-benefits')}}";
    });
   



$( function() {
    $("#Document").fileinput({
            "overwriteInitial":true,
            "initialPreviewAsData":true,
            @if(isset($quit_benefit->file) && $quit_benefit->file != '')
                "initialPreview": '{{url('/')}}/uploads/files/{{$quit_benefit->file->name}}',
                "initialPreviewConfig": [{
                    "caption":"{{$quit_benefit->file->name}}",
                }],
            @endif
            "showRemove":false,
            "showUpload":false,
            //"uploadUrl":  "#",
            //"uploadAsync": false,

            //"deleteUrl":"{!! url('/').'/home/deleteimage' !!}",
            "allowedFileExtensions": ['jpeg', 'jpg', 'png', 'JPEG'],
            "deleteExtraData":{"MediaFilesPath":"_file_del_","_file_del_":"","_token":"{{ csrf_token() }}","_method":"GET","id":"{!! isset($quit_benefit->id)?$quit_benefit->id:'' !!}" }
    })
});
   
</script>
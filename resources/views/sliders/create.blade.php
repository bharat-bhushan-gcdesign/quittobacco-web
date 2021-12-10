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
                            @if(isset($slider))
                                Edit Slider
                            @else
                                Add Slider
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
                            <a href="{{ route('sliders.index') }}">Slider</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($slider))
                    <form method="POST" id="sliderforms" name="slider" action="{{ route('sliders.update',['slider'=>$slider->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$slider->id}}">
                @else
                    <form method="POST" action="{{ route('sliders.store') }}" accept-charset="UTF-8" id="sliderforms" name="slider" class="form-horizontal" enctype="multipart/form-data">
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
                                                <input class="form-control input-height" name="title" type="text" id="title" value="{{ old('slider', isset($slider->title) ? $slider->title : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter slider title here.." >
                                                     
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Description</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">    
                                                <textarea rows="4" cols="50" class="form-control input-height" name="description"id="description"
                                                  minlength="1" required placeholder="Enter slider Description here.." style="resize: none;">{{ old('slider', isset($slider->description) ? $slider->description : null) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select Content Type</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">              
                                                <select class="form-control select2 input-height" id="type" name="type" required="true">
                                                    <option value="2">Select Content Type</option>
                                                        <option value="0" {{ (isset($slider->type) && $slider->type==0)  ? 'selected': '' }} >Text</option>
                                                        <option value="1" {{ (isset($slider->type) && $slider->type==1)  ? 'selected': '' }} >Image</option>
                                                </select>
                                                     
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-sm-3 input_field_sections">
                                                <h5 class="text-content">Text Content</h5>
                                                <h5 class="image-content">Select Image Content</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections text-content"> 
                                                <input class="form-control input-height text-content" name="text_content" type="text" id="content" value="{{ old('slider', isset($slider->content) && $slider->type==0 ? $slider->content : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]" placeholder="Enter slider text content here.." >
                                            </div>

                                            <div class="col-sm-9 input_field_sections image-content">                                  
                                                
                                                     
                                                <div data-provides="fileinput">
                                                    @if(isset($slider) && $slider->content!=null && $slider->type==1)
                                                        <img src="{{url('/')}}/uploads/files/{{$slider->content}}" id="slider-img-tag" width="50%" height="50%" name="image_content" />
                                                    @else
                                                        <img src="{{url('/')}}/defaults/upload.webp" id="slider-img-tag" width="50%" height="50%" name="image_content" />
                                                    @endif
                                                        <div class="customfile_btntypenew">
                                                            <div class="btn btn-primary btn-file" style="width: 50%;">
                                                           <h5 style="margin: 5px 0px;color: #fff;">Upload</h5>
                                                            @if(isset($slider) && $slider->file!=null)
                                                                <input required type="file" name="image_content" id="slider_img" class="fileinput-new" onchange="readURL(this);"  value="{{$slider->file->name}}" accept="image/x-png,image/jpeg,image/jpg">
                                                            @else
                                                                <input type="file" required name="image_content" id="slider_img" class="fileinput-new" onchange="readURL(this);"  value="{{url('/')}}/defaults/upload.webp" accept="image/x-png,image/jpeg,image/jpg">
                                                            @endif

                                                        </div>
                                                     </div>
                                                  </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row"> 
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Status</h5>
                                            </div>
                                            <div class="col-sm-9 input_field_sections">
                                                <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                                    <option value="1">Active</option>
                                                    <option value="0" {{ (isset($slider->status) && $slider->status==0)  ? 'selected': '' }}>InActive</option>
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
<script type="text/javascript">
    $(document).ready(function(){

        jQuery.validator.addMethod("noSpace", function(value, element) { 
            return value == '' || value.trim().length != 0;  
        },"No space please and don't leave it empty");

        jQuery.validator.addMethod("letterswithspace", function(value, element) {
            return this.optional(element) || /^[a-z|A-Z|0-9]+(?: [a-z|A-Z|0-9]+)*$/.test(value);
        },"letters only");


        jQuery.validator.addMethod("select", function(value, element) {
            if(value == 2){
                return false;
            }else{
                return true;
            }
        },"");

        jQuery.validator.addMethod("text", function(value, element) {
            var type = $('#type').children("option:selected").val();
            if(type == 0){
                return value == '' || value.trim().length != 0;
            }else{
                return true;
            }
        },"Please Enter Text Content");

        /*jQuery.validator.addMethod("image", function(value, element) {
            var type = $('#type').children("option:selected").val();
            if(type == 1){
                if($('#slider_img').val()){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        },"Please Upload Slider File");*/

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /[A-za-z0–9_]+(\s[A-Za-z0-9]+)?/.test(value);
        },"<span class='testing' style='color:red'>  Please enter only letters</span>");

        // jQuery.validator.addMethod("lettersonly", function(value, element) {
        //     return this.optional(element) || /^[a-z]+$/i.test(value);
        // }, "Letters only please"); 

        $("#sliderforms").validate({

            rules: {
                title: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                    remote: {
                        url: "/sliders/check-exist",
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
                description: {
                    noSpace:true,
                },
                type: {
                    select: true,
                },
                text_content: {
                    text: true,
                },
            },
            messages: {
                title: {
                    required: "Please Enter Slider Title",
                    noSpace: "Please Enter valid Name.",
                    remote: "Title Already Exists!",
                },
                description: {
                    noSpace: "Please Enter valid Description.",
                },
                type: {
                    select: "Please select any one",
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
        window.location.href = "{{url('/sliders')}}";
    });
   

    $('.select2').select2();
    $(document ).ready(function() {
        $('#type').change(function(){
            
            if(this.value == 0){
                $('.image-content').css('display','none');
                $('.text-content').css('display','block');
            }
            else if(this.value == 1){
                $('.text-content').css('display','none');
                $('.image-content').css('display','block');
            }else{
                $('.text-content').css('display','none');
                $('.image-content').css('display','none');
            }
        });

        if($('#type').val() == 0){
            $('.image-content').css('display','none');
            $('.text-content').css('display','block');
        }
        else if($('#type').val() == 1){
            $('.text-content').css('display','none');
            $('.image-content').css('display','block');
        }else{
            $('.text-content').css('display','none');
            $('.image-content').css('display','none');
        }
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
           $('#slider-img-tag').show();
           $('#slider-img-tag').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
      }
      else
      {
        $("#imgerror").val(1);
        $('#slider-img-tag').hide();
      }
    }
 }
</script>
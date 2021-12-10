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
                           @if(isset($carving_video))
                                Add Carving Video
                               @else
                                Edit Carving Video
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
                            <a href="{{ route('carving_videos.index') }}">Carving Video</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($carving_video))
                    <form method="POST" id="carving_videoforms" name="carving_video" action="{{ route('carving_videos.update',['carving_video'=>$carving_video->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$carving_video->id}}">
                @else
                    <form method="POST" action="{{ route('carving_videos.store') }}" accept-charset="UTF-8" id="carving_videoforms" name="carving_video" class="form-horizontal" enctype="multipart/form-data">
                @endif
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Name</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="name" type="text" id="name" value="{{ old('carving_video', isset($carving_video->name) ? $carving_video->name : null) }}"   required="" pattern="[A-Za-z -]"placeholder="Enter  name here.." >
                                                     
                                            </div>
                                        </div>

                                         <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>Thumbnail Image</h5>
                                         </div>
                                            <div class="col-sm-9 input_field_sections inputfile_error">
                                         @if(isset($carving_video))
                                            <input class="form-control input-height" name="thumbnail" type="file" id="thumbnail" data-show-upload="false" data-show-caption="true"  data-allowed-file-extensions='["jpg","JPEG", "jpeg","png"]'>
                                        @else
                                         <input class="form-control input-height" name="thumbnail" type="file" id="thumbnail" data-show-upload="false" data-show-caption="true" required data-allowed-file-extensions='["jpg","JPEG", "jpeg","png"]'>
                                         @endif

                                        </div>
                                            <div id="logoerr"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select Video</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                           
                                                
                                                <input type="file" name="video" id="Document" value="{{ old('carvingvideo', isset($carvingvideo->videos) ? $carvingvideo->videos : null) }}" />
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
                                                    <option value="0" {{ (isset($carving_video->status) && $carving_video->status==0)  ? 'selected': '' }}>InActive</option>
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

        // jQuery.validator.addMethod("letterswithspace", function(value, element) {
        //     return this.optional(element) || /^[a-z|A-Z0-9]+(?: [a-z|A-Z0-9]+)*$/.test(value);
        // },"letters only");

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /[A-Za-z0-9]+(\s[A-Za-z0-9]+)?/.test(value);
        },"<span class='testing' style='color:red'>  Please enter only letters</span>");

        // jQuery.validator.addMethod("lettersonly", function(value, element) {
        //     return this.optional(element) || /^[a-z]+$/i.test(value);
        // }, "Letters only please"); 

        $("#carving_videoforms").validate({

            rules: {
                tobacco_id:{
                     required:true,
                    },


                name: {
                    
                    noSpace:true,
                    lettersonly: true,
                    letterswithspace: true,
                    remote: {
                        url: "/tobacco-products/check-exist",
                        type: "post",
                        data: {
                            id: function() {
                                return $( "#id" ).val();
                            },
                            name: function() {
                                return $( "#name" ).val();
                            },
                            _token: function() {
                                return "{{csrf_token()}}"
                            }
                        }
                    }
                }, 
                description: {
                    required:true,
                    noSpace:true,
                }, 
            },
            messages: {

                tobacco_id:{
                     required:"Please Select any one",
                    },
                name: {
                    required: "Please Enter Carving Video Name",
                    noSpace: "Please Enter valid Name.",
                    remote: "Name Already Exists!",
                },
                description: {
                    required: "Please Enter Description",
                    noSpace: "Please Enter valid Description.",
                }
            },
             errorPlacement: function(error, element) {
                                if (element.attr("name") == "thumbnail_image" ){
                                    error.insertAfter("#logoerr");
                                }else {
                                    error.insertAfter(element); // default error placement.
                                }
                            },
            submitHandler: function(form){
                console.log(1)
                $('form input[type=submit]').prop('disabled', true);
                form.submit();
            },
        });
    })
    function readURL(input) {
    if (input.files && input.files[0]) {
       var file = input.files[0];
       var fileType = file["type"];
       var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg","mp4/video"];
       if ($.inArray(fileType, validImageTypes) != -1) {
         var reader = new FileReader();
         reader.onload = function (e) {
           $("#imgerror").val(0);
           $('#carving_video-img-tag').show();
           $('#carving_video-img-tag').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
      }
      else
      {
        $("#imgerror").val(1);
        $('#carving_video-img-tag').hide();
      }
    }
}

$( function() {
    $("#Document").fileinput({
            "overwriteInitial":true,
            "initialPreviewAsData":true,
            @if(isset($carving_video->videos) && $carving_video->videos != '')
            "initialPreview": '{{ url("/")}}/uploads/video/{{ $carving_video->videos }}',
            "initialPreviewConfig": [{
                "caption":"{{$carving_video->video}}",
                "url":"{{ url('/') }}/home/deleteimage",
                "downloadUrl": '{{ url("/")}}/uploads/video/{{ $carving_video->videos }}',
                    "filetype" : "video/MP4",
                    "type" : "video",
            }],
            @endif
            "deleteUrl":"{!! url('/').'/home/deleteimage' !!}",
            "showRemove":false,
            "showUpload":false,
            "allowedFileExtensions": ['MP4', 'OGG', 'WEBM', 'FLV'], 
            "deleteExtraData":{"MediaFilesPath":"_file_del_","_file_del_":"","_token":"{{ csrf_token() }}","_method":"GET","id":"{!! isset($carving_video->id)?$carving_video->id:'' !!}" }
        })
    });
    $("#cancelform").click(function() {
        window.location.href = "{{url('/carving-videos')}}";
    });

    $('#thumbnail').fileinput({
                "overwriteInitial":true,
                "initialPreviewAsData":true,
                @if (isset($carving_video->thumbnail) && $carving_video->thumbnail != '')
                "initialPreview": '{{url('/')}}/uploads/files/{{$carving_video->thumbnail}}',
                "initialPreviewConfig": [{
                "caption":"{{$carving_video->thumbnail}}",
                }],
                @endif
                "showUpload":false,
                "allowedFileExtensions": ['jpeg', 'jpg', 'png', 'JPEG'],
                "deleteExtraData":{"MediaFilesPath":"_file_del_", "_file_del_":"", "_token":"{{ csrf_token() }}", "_method":"GET", "id":"{!! isset($carving_video->id)?$carving_video->id:'' !!}" }
            });
   
</script>
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
                            @if(isset($learning))
                                Edit Learning
                            @else
                                Add Learning
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
                            <a href="{{ route('learnings.create') }}">Learning</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($learning))
                    <form method="POST" id="learningforms" name="learning" action="{{ route('learnings.update',['learning'=>$learning->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$learning->id}}">
                @else
                    <form method="POST" action="{{ route('learnings.store') }}" accept-charset="UTF-8" id="learningforms" name="learning" class="form-horizontal" enctype="multipart/form-data">
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
                                                <input class="form-control input-height" name="title" type="text" id="title" value="{{ old('learning', isset($learning->title) ? $learning->title : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter learning title here.." >
                                                     
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Description</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="description" type="text" id="description" value="{{ old('learning', isset($learning->description) ? $learning->description : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter Learning Description here.." >
                                                     
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select Video</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                           
                                                
                                                <input type="file" name="video" id="Document" value="{{ old('Document', isset($circulars->Document) ? $circulars->Document : null) }}" />
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
                                                    <option value="0" {{ (isset($learning->status) && $learning->status==0)  ? 'selected': '' }}>InActive</option>
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
                title: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                    remote: {
                        url: "/learnings/check-exist",
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
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                }, 
                cost: {
                    minlength:1,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: false,
                }, 
            },
            messages: {
                title: {
                    required: "Please Enter Learning Title",
                    noSpace: "Please Enter valid Title.",
                    remote: "Title Already Exists!",
                },
                description: {
                    required: "Please Enter Description",
                    noSpace: "Please Enter valid Description.",
                },
                cost: {
                    required: "Please Enter Amount",
                    noSpace: "Please Enter valid Amount.",
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
        window.location.href = "{{url('/learnings')}}";
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
    $('.datepicker').datepicker({
        labelMonthNext: 'Go to the next month',
        labelMonthPrev: 'Go to the previous month',
        labelMonthSelect: 'Pick a month from the dropdown',
        labelYearSelect: 'Pick a year from the dropdown',
        selectMonths: true,
        selectYears: true
    })

    $( function() {
    $("#Document").fileinput({
            "overwriteInitial":true,
            "initialPreviewAsData":true,
            @if(isset($circulars->Document) && $circulars->Document != '')
            "initialPreview": '{{ $url}}circulars/{{ $circulars->Document }}',
            "initialPreviewConfig": [{
                "caption":"{{$circulars->Document}}",
                "url":"{{ url('/') }}/home/deleteimage",
                "downloadUrl": "{{ $url}}circulars/{{$circulars->Document}}",
                @if((explode('.',$circulars->Document))[1] == 'pdf')
                    "filetype" : "application/pdf",
                    "type" : "pdf",
                @elseif((explode('.',$circulars->Document))[1] == "doc" || (explode('.',$circulars->Document))[1] == 'docx')
                    "type" : "office",
                @endif

            }],
            @endif
            "showRemove":false,
            "showUpload":false,
            //"uploadUrl":  "#",
            //"uploadAsync": false,

            //"deleteUrl":"{!! url('/').'/home/deleteimage' !!}",
            "allowedFileExtensions": ['jpeg', 'jpg', 'png', 'gif','pdf','doc','docx'], 
            "deleteExtraData":{"MediaFilesPath":"_file_del_","_file_del_":"","_token":"{{ csrf_token() }}","_method":"GET","id":"{!! isset($circulars->Id)?$circulars->Id:'' !!}" }
        })
    });
</script>
<link type="text/css" rel="stylesheet" href="https://v2.edukool.com/assets/plugins/fileinput/fileinput.min.css">
<script type="text/javascript" src="https://v2.edukool.com/assets/plugins/fileinput/fileinput.min.js"></script>
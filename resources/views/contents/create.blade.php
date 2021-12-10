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
                            @if(isset($content))
                                Edit Content
                            @else
                                Add Content
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
                            <a href="{{ route('contents.index') }}">Content</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($content))
                    <form method="POST" id="contentforms" name="content" action="{{ route('contents.update',['content'=>$content->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$content->id}}">
                @else
                    <form method="POST" action="{{ route('contents.store') }}" accept-charset="UTF-8" id="contentforms" name="content" class="form-horizontal" enctype="multipart/form-data">
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
                                                <input class="form-control input-height" name="title" type="text" id="title" value="{{ old('content', isset($content->title) ? $content->title : null) }}" minlength="1" maxlength="55" required="" pattern="[A-Za-z -]"placeholder="Enter content name here.." >
                                                     
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Description</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <textarea name="description" id="description" class="ckeditor form-control">{{ ( isset($content->description) ? base64_decode($content->description) : null) }}</textarea>
                                                     
                                            </div>
                                        </div>
                                         <div class="row"> 
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Status</h5>
                                            </div>
                                            <div class="col-sm-9 input_field_sections">
                                                <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                                    <option value="1">Active</option>
                                                    <option value="0" {{ (isset($content->status) && $content->status==0)  ? 'selected': '' }}>InActive</option>
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
<script>
  CKEDITOR.replace( 'description');
     CKEDITOR.on('instanceReady', function(ev)
{
    console.log('sdad');
        var dtd = CKEDITOR.dtd;
        for (var e in CKEDITOR.tools.extend({}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent)) {
                ev.editor.dataProcessor.writer.setRules(e, {
                        indent:           false,
                        breakBeforeOpen:  false,
                        breakAfterOpen:   false,
                        breakBeforeClose: false,
                        breakAfterClose:  false,
        fillEmptyBlocks:false;
                        
                }); 
        }   
});
</script> 
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


        jQuery.validator.addMethod("ckedit", function(value, element) {
            var res = value.replace("<p>", "");
            res = res.replace("</p>", "");
            res = res.replace(/\&nbsp;/g, "");
            res = res.replace(/ /g, "");
            if(res.length === 1 || res.length === 0){
            	return false;
            }else{
            	return true;
            }
        },"Please Enter Something");

        
        $("#contentforms").validate({
            ignore: [],
            debug: false,
            rules: {
                title: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                    
                    remote: {
                        url: "/contents/check-exist",
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
                description:{
                    required: function() 
                    {
                     CKEDITOR.instances.description.updateElement();
                    },
                    ckedit: true,
                    
                },
            },
            
            messages: {
                title: {
                    required: "Please Enter Content Title",
                    noSpace: "Please Enter valid Title.",
                    remote: "Title Already Exists!",
                    
                },
                description: {
                    noSpace: "Please Enter valid Description.",
                },
            },
            submitHandler: function(form){
                $('form input[type=submit]').prop('disabled', true);
                form.submit();
            },
        });
    })
    $("#cancelform").click(function() {
        window.location.href = "{{url('/contents')}}";
    });

</script>



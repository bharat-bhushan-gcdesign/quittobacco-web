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
                            @if(isset($tobacco_product))
                                Edit Tobacco Product
                            @else
                                Add Tobacco Product
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
                            <a href="{{ route('tobacco_products.index') }}">Tobacco Product</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($tobacco_product))
                    <form method="POST" id="tobacco_productforms" name="tobacco_product" action="{{ route('tobacco_products.update',['tobacco_product'=>$tobacco_product->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$tobacco_product->id}}">
                @else
                    <form method="POST" action="{{ route('tobacco_products.store') }}" accept-charset="UTF-8" id="tobacco_productforms" name="tobacco_product" class="form-horizontal" enctype="multipart/form-data">
                @endif
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select Tobacco Type</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                       
                                                <select name="tobacco_id" class="form-control select2 input-height Countryid" id="tobacco_id">
                                                    <option value="">Select Tobacco Type</option>
                                                    @foreach($tobaccos as $tobacco)
                                                        <option value="{{$tobacco->id}}"@if(isset($tobacco_product)) @if($tobacco_product->tobacco_id==$tobacco->id) selected @endif @endif>{{$tobacco->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Name</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="name" type="text" id="name" value="{{ old('tobacco_product', isset($tobacco_product->name) ? $tobacco_product->name : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter  name here.." >
                                                     
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Description</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                           
                                                <textarea class="form-control input-height" name="description" type="text" id="description"placeholder="Enter  Description here.." rows="4" cols="50"  style="resize: none;" >{{ old('tobacco_product', isset($tobacco_product->description) ? $tobacco_product->description : null) }}</textarea>
                                                     
                                            </div>
                                        </div>
                                         <div class="row"> 
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Status</h5>
                                            </div>
                                            <div class="col-sm-9 input_field_sections">
                                                <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                                    <option value="1">Active</option>
                                                    <option value="0" {{ (isset($tobacco_product->status) && $tobacco_product->status==0)  ? 'selected': '' }}>InActive</option>
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
            return this.optional(element) || /^[a-z|A-Z0-9]+(?: [a-z|A-Z0-9]+)*$/.test(value);
        },"letters only");

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /[A-Za-z0-9]+(\s[A-Za-z0-9]+)?/.test(value);
        },"<span class='testing' style='color:red'>  Please enter only letters</span>");

        // jQuery.validator.addMethod("lettersonly", function(value, element) {
        //     return this.optional(element) || /^[a-z]+$/i.test(value);
        // }, "Letters only please"); 

        $("#tobacco_productforms").validate({

            rules: {
                tobacco_id:{
                     required:true,
                    },


                name: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
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
                    noSpace:true,
                }, 
            },
            messages: {

                tobacco_id:{
                     required:"Please Select any one",
                    },
                name: {
                    required: "Please Enter Tobacco Product Name",
                    noSpace: "Please Enter valid Name.",
                    remote: "Name Already Exists!",
                },
                description: {
                    noSpace: "Please Enter valid Description.",
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
        window.location.href = "{{url('/tobacco-products')}}";
    });
   
</script>
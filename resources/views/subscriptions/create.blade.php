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
                            @if(isset($subscription))
                                Edit Subscription
                            @else
                                Add Subscription
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
                            <a href="{{ route('subscriptions.index') }}">Subscription</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($subscription))
                    <form method="POST" id="subscriptionforms" name="subscription" action="{{ route('subscriptions.update',['subscription'=>$subscription->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$subscription->id}}">
                @else
                    <form method="POST" action="{{ route('subscriptions.store') }}" accept-charset="UTF-8" id="subscriptionforms" name="subscription" class="form-horizontal" enctype="multipart/form-data">
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
                                                <input class="form-control input-height" name="title" type="text" id="title" value="{{ old('subscription', isset($subscription->title) ? $subscription->title : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter subscription name here.." >
                                                     
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Description</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">    
                                                <textarea rows="4" cols="50" class="form-control input-height" name="description" id="description" minlength="1"  placeholder="Enter Subscription Description here.." style="resize: none;">{{ old('subscription', isset($subscription->description) ? $subscription->description : null) }}</textarea>                    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Amount</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="amount" type="number" id="amount" value="{{ old('subscription', isset($subscription->amount) ? $subscription->amount : null) }}" min="1"  required="" placeholder="Enter Subscription Amount here.." >
                                                     
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Status</h5>
                                            </div>
                                            <div class="col-sm-9 input_field_sections">
                                                <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                                    <option value="1">Active</option>
                                                    <option value="0" {{ (isset($subscription->status) && $subscription->status==0)  ? 'selected': '' }}>InActive</option>
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

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /[A-za-z0–9_]+(\s[A-Za-z0-9]+)?/.test(value);
        },"<span class='testing' style='color:red'>  Please enter only letters</span>");

        // jQuery.validator.addMethod("lettersonly", function(value, element) {
        //     return this.optional(element) || /^[a-z]+$/i.test(value);
        // }, "Letters only please"); 

        $("#subscriptionforms").validate({

            rules: {
                title: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                    letterswithspace:true,
                    remote: {
                        url: "/subscriptions/check-exist",
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
                amount: {
                    required: true,
                    minlength:1,
                    noSpace:true,
                    lettersonly: false,
                }, 
            },
            messages: {
                title: {
                    required: "Please Enter Subscription Title",
                    noSpace: "Please Enter valid Title.",
                    remote: "Title Already Exists!",
                    letterswithspace: "PLease Enter letters only without spaces",
                },
                description: {
                    noSpace: "Please Enter valid Description.",
                },
                amount: {
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
        window.location.href = "{{url('/subscriptions')}}";
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
                    $('#subscription-img-tag').show();
                    $('#subscription-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                $("#imgerror").val(1);
                $('#subscription-img-tag').hide();
            }
        }
    }
</script>
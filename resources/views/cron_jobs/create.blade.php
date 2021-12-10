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
                            @if(isset($cron_job))
                                Edit Cron Job
                            @else
                                Add Cron Job
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
                            <a href="{{ route('cron_jobs.index') }}">Cron Job</a>
                        </li>
                             
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="card-body" id="bar-parent">
                @if(isset($cron_job))
                    <form method="POST" id="cron_jobforms" name="cron_job" action="{{ route('cron_jobs.update',['cron_job'=>$cron_job->id]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$cron_job->id}}">
                @else
                    <form method="POST" action="{{ route('cron_jobs.store') }}" accept-charset="UTF-8" id="cron_jobforms" name="cron_job" class="form-horizontal" enctype="multipart/form-data">
                @endif
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Task</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">                                  
                                                <input class="form-control input-height" name="task" type="text" id="task" value="{{ old('cron_job', isset($cron_job->task) ? $cron_job->task : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter cron_job task here.." >
                                                     
                                            </div>
                                        </div>

                                         <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Description</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">    
                                                <textarea rows="4" cols="50" class="form-control input-height" name="description" id="description" minlength="1" required placeholder="Enter cron_job Description here.." style="resize: none;">{{ old('cron_job', isset($cron_job->description) ? $cron_job->description : null) }}</textarea>                         
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 input_field_sections">
                                                <h5>Select Schedule Type</h5>
                                            </div>    
                                            <div class="col-sm-9 input_field_sections">              
                                               <select class="form-control select2 input-height" id="resourceType" name="schedule_id" required="true">
                                                    <option value="0">Select Schedule Type</option>
                                                    @foreach($schedules as $schedule)
                                                        <option value="{{$schedule->id}}" 
                                                            @if(isset($cron_job->schedule_id))
                                                            @if($cron_job->schedule_id == $schedule->id)
                                                        selected 
                                                        @endif
                                                        @endif>{{$schedule->for}}</option>
                                                    @endforeach
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
                                                    <option value="0" {{ (isset($cron_job->status) && $cron_job->status==0)  ? 'selected': '' }}>InActive</option>
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


        jQuery.validator.addMethod("select", function(value, element) { 
            if(value == 0){
                return false;
            }else{
                return true;
            }
        },"Please select any one of option");

        jQuery.validator.addMethod("letterswithspace", function(value, element) {
            return this.optional(element) || /^[a-z|A-Z|0-9]+(?: [a-z|A-Z|0-9]+)*$/.test(value);
        },"letters only");

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /[A-za-z0–9_]+(\s[A-Za-z0-9]+)?/.test(value);
        },"<span class='testing' style='color:red'>  Please enter only letters</span>");

        // jQuery.validator.addMethod("lettersonly", function(value, element) {
        //     return this.optional(element) || /^[a-z]+$/i.test(value);
        // }, "Letters only please"); 

        $("#cron_jobforms").validate({

            rules: {
                task: {
                    minlength:3,
                    maxlength:50,
                    noSpace:true,
                    lettersonly: true,
                    letterswithspace:true,
                    remote: {
                        url: "/cron-jobs/check-exist",
                        type: "post",
                        data: {
                            id: function() {
                                return $( "#id" ).val();
                            },
                            task: function() {
                                return $( "#task" ).val();
                            },
                            _token: function() {
                                return "{{csrf_token()}}"
                            }
                        }
                    }
                }, 
                description: {
                    noSpace:true,
                    required:true,
                },
                schedule_id: {
                    select: true,
                },
            },
            messages: {
                task: {
                    required: "Please Enter Cron Job Name",
                    noSpace: "Please Enter valid Name.",
                    remote: "Name Already Exists!",
                    letterswithspace: "PLease Enter letters only without spaces",
                },
                description: {
                    required: "Please Enter Description",
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
        window.location.href = "{{url('/cron-jobs')}}";
    });
   
</script>
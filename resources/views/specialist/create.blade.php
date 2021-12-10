@include('header')
@include('sidebar')

<!-- /#left -->
  <style>
.error {
      color: red;
      
   }
</style>
        <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar">
                   <div class="row no-gutters">
                       <div class="col-sm-5 col-lg-6 skin_txt">
                           <h4 class="nav_top_align">
                               <i class="fa fa-plus"></i>
                                 @if($pid=="")
                               Add Specialist
                               @else
                               Edit Specialist
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
                                   <a href="{{url('/specialist')}}">Specialist</a>
                               </li>
                             
                           </ol>
                       </div>
                   </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container forms">
                    <div class="card-body" id="bar-parent">
                      @if($pid=="")
            <form method="POST" action="{{ url('specialist/store') }}"" accept-charset="UTF-8" id="specialistforms" name="specialist" class="form-horizontal">
              @else
                 <form method="POST" action="{{ url('specialist/store') }}"" accept-charset="UTF-8" id="specialistforms" name="specialist" class="form-horizontal">
              @endif
                    <div class="row">
                        <div class="col">
                            <div class="card">

                                          {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>Specialist Name</h5>
                                        </div>    
                                       <div class="col-sm-9 input_field_sections">                                       
                                          <input class="form-control input-height" name="specialist" type="text" id="specialist" value="{{ old('specialist', isset($eventpayment->specialist) ? $eventpayment->specialist : null) }}" minlength="1" maxlength="30" required="" pattern="[A-Za-z -]"placeholder="Enter Specialist name here.." >
                                             
                                         </div>
                                      </div>
                                    <div class="row"> 
                                       <div class="col-sm-3 input_field_sections">
                                          <h5>Status</h5>
                                        </div>
                                        <div class="col-sm-9 input_field_sections">
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($eventpayment->status) && $eventpayment->status==0)  ? 'selected': '' }}>InActive</option>
                                             </select>
                                        </div>
                                    </div>  

                                                           
                                </div>
                            </div>
                        </div>
                    </div>
<input type="hidden" name="id" id="id" value="{{$pid}}">
                    <!-- /.row -->
                    <div class=" m-t-35">

                        <div class="form-actions form-group row">
                            <div class="col-xl-12 text-center">
                              <input type="hidden" name="pid" value="{{$pid}}">
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
    }, "No space please and don't leave it empty");

jQuery.validator.addMethod("letterswithspace", function(value, element) {
    return this.optional(element) || /^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/.test(value);
}, "letters only");

jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /[A-Za-z]+(\s[A-Za-z]+)?/.test(value);
}, "<span class='testing' style='color:red'>  Please enter only letters</span>");

//     jQuery.validator.addMethod("lettersonly", function(value, element) {
//   return this.optional(element) || /^[a-z]+$/i.test(value);
// }, "Letters only please"); 

    $("#specialistforms").validate({
       rules: {
           specialist: {
            minlength:3,
            maxlength:50,
          noSpace:true,
           lettersonly: true,
          remote: {
                  url: "/check",
                type: "post",
                data: {
                  specialist: function() {
                    return $( "#specialist" ).val();
                  },
                   id: function() {
                    return $( "#id" ).val();
                  },
                  _token: function() {
                    return "{{csrf_token()}}"
                  }
                  
                }
            }

              }, 
                  },
       messages: {
             
        specialist: {
            required: "Please Enter Name",
            noSpace: "Please Enter valid Name.",
             remote: "Name Already Exists!",
                 }
         
       
                   },

   
                      submitHandler: function(form){
      $('form input[type=submit]').prop('disabled', true);
      form.submit();
    },
    });


  })


$("#cancelform").click(function() {
   window.location.href = "{{url('/specialist')}}";
});

</script>
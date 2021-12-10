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
                               Add State
                               @else
                               Edit State
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
                                   <a href="{{url('/country')}}">Country</a>
                               </li>
                             
                           </ol>
                       </div>
                   </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container forms">
                    <div class="card-body" id="bar-parent">
                      
               <form method="POST" action="{{url('state/store')}}" accept-charset="UTF-8" id="stateforms" name="create_country" class="form-horizontal" id="stateforms">
             
                    <div class="row">
                        <div class="col">
                            <div class="card">

                                          {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>Country Name</h5>
                                        </div>    
                                       <div class="col-sm-9 input_field_sections">                                       
                                         <select name="country_id" id="country_id" class="form-control select2 input-height">
                                            <option value="">Select Country</option>
                                            @foreach($country as $val)
                                            <option value="{{$val->id}}" {{ (isset($states->country_id) && $states->country_id==$val->id)  ? 'selected': '' }} >{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                         </div>
                                      </div>   
                                      <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>State Name</h5>
                                        </div>    
                                       <div class="col-sm-9 input_field_sections">                                       
                                         <input class="form-control input-height" name="name" type="text" id="name" value="{{ old('name', isset($states->name) ? $states->name : null) }}" minlength="1" maxlength="100" required="true" placeholder="Enter State Name here.." autocomplete="off">
                                         </div>
                                      </div>
                                    <div class="row"> 
                                       <div class="col-sm-3 input_field_sections">
                                          <h5>Status</h5>
                                        </div>
                                        <div class="col-sm-9 input_field_sections">
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($states->status) && $states->status==0)  ? 'selected': '' }}>InActive</option>
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

<script>
  CKEDITOR.replace( 'description');
</script>  
 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>


<script type="text/javascript">

$(document).ready(function () {

     jQuery.validator.addMethod("noSpace", function(value, element) { 
      return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");

 
jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "<span class='testing' style='color:red'>  Please enter only letters</span>");

    $('#stateforms').validate({ 
    
    rules: {
        country_id: {
            required: true,
        },
        name: {
                noSpace:true,
            required: true,
            lettersonly: true,
            //verifyCountry: true,
            remote: {
                url: "/check_statename",
                type: "post",
                data: {
                  name: function() {
                    return $( "#name" ).val();
                  },
                  id: function() {
                    return $( "#id" ).val();
                  },
                  country_id: function() {
                    return $( "#country_id" ).val();
                  },
                  _token: function() {
                    return "{{csrf_token()}}"
                  }
                }
            }
        }
    },
    messages: {
        country_id: {
                    required: "Country field is required",
                },
        name: {
            required: "The State Name field is required.",
            lettersonly: "Invalid Formats.",
            remote: "State Already Exists!",
            noSpace: "Please Enter valid state.",
            //verifyCountry:"Country  Already Exists"
        }
    },
    submitHandler: function(form) {
                        form.submit();
                     }
    });
});
$("#cancelform").click(function() {
   window.location.href = "{{url('/state')}}";
});

</script>


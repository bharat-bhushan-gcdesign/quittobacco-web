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
                               Add City
                               @else
                               Edit City
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
                                   <a href="{{url('/city')}}">City</a>
                               </li>
                             
                           </ol>
                       </div>
                   </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container forms">
                    <div class="card-body" id="bar-parent">
                      
              <form method="POST" action="{{route('city.store')}}" accept-charset="UTF-8" id="cityforms" name="create_country" class="form-horizontal">
             
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
                                           <select name="country_id" class="form-control select2 input-height Countryid" id="country_id">
                                              <option value="">Select Country</option>
                                              @foreach($country as $k=>$value)
                                              <option value="{{$k}}"@if(isset($city->country_id)) @if($city->country_id==$k) selected @endif @endif>{{$value}}</option>
                                              @endforeach
                                          </select>
                                         </div>
                                      </div>   
                                      <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>State Name</h5>
                                        </div>    
                                       <div class="col-sm-9 input_field_sections">                                       
                                       <select name="state_id" class="form-control select2 input-height Stateid" id="state_id">
                                          <option value="">Select State</option>
                                           @if (($pid) != '')
                                                            @foreach ($states as $k=>$v)
                                                            <option value="{{ $k }}" @if($city->state_id==$k) selected @endif>{{ $v }}</option>
                                                            @endforeach 
                                                            @endif
                                      
                                      </select>
                                         </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>City Name</h5>
                                        </div>    
                                       <div class="col-sm-9 input_field_sections">                                       
                                     <input class="form-control input-height" name="name" type="text" id="name" value="{{ old('name', isset($city->name) ? $city->name : null) }}" minlength="1" maxlength="100" required="true" placeholder="Enter City Name.." autocomplete="off">
                                         </div>
                                      </div>
                                    <div class="row"> 
                                       <div class="col-sm-3 input_field_sections">
                                          <h5>Status</h5>
                                        </div>
                                        <div class="col-sm-9 input_field_sections">
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($city->status) && $city->status==0)  ? 'selected': '' }}>InActive</option>
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
 $(function () {
       $(document).off('change', ".Countryid");
       $(document).on('change', ".Countryid", function () {
       var target = $(this).closest('.form-horizontal').find(".Stateid");
       $.get("/city/statelist?q="+this.value, function (data) {
           target.find("option").remove();
           $(target).select2({
               data: $.map(data, function (d) {
                   d.id = d.id;
                   d.text = d.text;
                   return d;
                    })
                }).trigger('change');
            });
        });
         });
    </script>
<script>
$(document).ready(function () {
    jQuery.validator.addMethod("noSpace", function(value, element) { 
      return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");

 
jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "<span class='testing' style='color:red'>  Please enter only letters</span>");

    $('#cityforms').validate({ 
    
    rules: {
        country_id: {
            required: true,
        },
        state_id: {
            required: true,
        },
        name: {
            required: true,
            lettersonly: true,
            //verifyCountry: true,
               noSpace:true,
            remote: {
                url: "/check-cityname",
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
                  state_id: function() {
                    return $( "#state_id" ).val();
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
                state_id: {
                    required: "State field is required",
                },
        name: {
            required: "The City Name field is required.",
            lettersonly: "Invalid Formats.",
            remote: "City Already Exists!",
                 noSpace: "Please Enter valid city.",
            //verifyCountry:"Country  Already Exists"
        }
    },
    submitHandler: function(form) {
                        form.submit();
                     }
    });
});

$("#cancelform").click(function() {
   window.location.href = "{{url('/city')}}";
});

</script>


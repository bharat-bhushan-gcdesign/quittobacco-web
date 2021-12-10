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
                               Add Country
                               @else
                               Edit Country
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
            <form method="POST" action="{{ url('country/store') }}"" accept-charset="UTF-8" id="countryforms" name="create_country" class="form-horizontal">
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
                                          <input class="form-control input-height" name="name" type="text" id="Name" value="{{ ( isset($country->name) ? $country->name : null) }}" minlength="1" maxlength="100" required="true" placeholder="Enter Country name here.." autocomplete="off">
                                             
                                         </div>
                                      </div>
                                    <div class="row"> 
                                       <div class="col-sm-3 input_field_sections">
                                          <h5>Status</h5>
                                        </div>
                                        <div class="col-sm-9 input_field_sections">
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($cms->status) && $cms->status==0)  ? 'selected': '' }}>InActive</option>
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


$( document ).ready(function() {
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z ]+$/i.test(value);
}, "<span class='testing' style='color:red'>  Please enter only letters</span>");

});

/*$('input, text').blur(function() {
        var value = $.trim( $(this).val() );
        $(this).val( value );
    });*/
$(function() {
  
   $( "#countryforms" ).validate({
      ignore: [],
      rules: {    
        name: {
            required: true,
            minlength:3,
            maxlength:50
              },
        description:{
           required: function() 
              {
               CKEDITOR.instances.description.updateElement();
              }, 
          },
        },
       messages: {
             
        name: {
            required: "Please Enter Country Name"
                 }, 
        description: {
            required: "Please Enter Description"
                 },     
       
                   },


                   submitHandler: function(form){
      $('form input[type=submit]').prop('disabled', true);
      form.submit();
    },
   });  
});
$("#cancelform").click(function() {
   window.location.href = "{{url('/country')}}";
});

</script>
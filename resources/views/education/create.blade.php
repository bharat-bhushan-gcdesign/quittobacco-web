@include('header')
@include('sidebar')

<!-- /#left -->
<style>
.error{
  color:red;
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
                                Add Education
                               @else
                                Edit Education
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
                                   <a href="{{url('/education')}}">Education</a>
                               </li>
                             
                           </ol>
                       </div>
                   </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container forms">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <form method="POST" action="{{url('education/savetitle')}}" id="titleforms" name="edit_country" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                    
                                       <div class="col-sm-6 input_field_sections">
                                            <h5>Name </h5>
                                           <input type="text" class="form-control" name="name" id="name" value="{{ old('name', isset($education->name) ? $education->name : null) }}" 
                                           placeholder="Enter Name here.." minlength="1" maxlength="30"  onkeypress="return lettersOnly(event)"/>
                                           <input class="form-control input-height" name="id" type="hidden" id="id" value="{{ $pid }}" minlength="1" maxlength="100" required="true" placeholder="Enter Country name here.." autocomplete="off">
  
                                         </div>

                                       <div class="col-sm-6 input_field_sections">
                                          <h5>Status</h5>
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($education->status) && $education->status==0)  ? 'selected': '' }}>InActive</option>
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
                <div class="modal fade" id="search_modal" tabindex="-1" role="dialog"
                     aria-hidden="true">
                    <form>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="float-right" aria-hidden="true">&times;</span>
                                </button>
                                <div class="input-group search_bar_small">
                                    <input type="text" class="form-control" placeholder="Search..." name="search">
                                    <span class="input-group-btn">
        <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
      </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- /#content -->
    </div>
<!-- startsec End -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"
   type="text/javascript"></script>
   @include('footer')
 
</script>
<!-- <script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
 

     <script>
 
  CKEDITOR.replace( 'description');
</script>  -->
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"
   type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script language="javascript">

jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-zA-Z0-9\s& ]+$/i.test(value);
}, "<span class='testing' style='color:red'>  Please enter only letters</span>");

 $.validator.addMethod("nowhitespace", function(value, element) {
      return this.optional(element) || value.trim()!="";
      }, "No white space please");

$(function() {
  
   $( "#titleforms" ).validate({
       rules: {
               
        name: {
			 lettersonly: true,
            required: true,
           
            nowhitespace:true,
            minlength:2,
            maxlength:30,
                remote: {
                url: "/education/check-Title",
                type: "post",
                data: {
                  name: function() {
                    return $( "#name" ).val();
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
             
        name: {
            required: "Please Enter Name",
            lettersonly: "only allowed alphabets.",
            nowhitespace:"Name Field is invalid",
            remote: "Name Already Exists!",
                 },

               
       
                   }
   });  
});
$("#cancelform").click(function() {
       window.location.href = "{{url('/education')}}";
   }); 
 function lettersOnly() 
{
            var charCode = event.keyCode;

            if ((charCode > 48 && charCode < 57) ||(charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8 || charCode == 32)

                return true;
            else
                return false;
}
</script>

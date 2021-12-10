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
                               Add FAQ
                               @else
                               Edit FAQ
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
                                   <a href="{{url('/faq')}}">FAQ</a>
                               </li>
                             
                           </ol>
                       </div>
                   </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container forms">
                    <form method="POST" action="{{url('faq/savefaq')}}" id="adforms" name="edit_country" class="form-horizontal">
                    <div class="row">
                        <div class="col">
                            <div class="card">

                                          {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>Question</h5>
                                        </div>    
                                       <div class="col-sm-9 input_field_sections">                                       
                                         <!--   <input type="text" class="form-control" name="name" id="name" value="{{ ( isset($faq->question) ? $faq->question : null) }}" placeholder="Enter Title here.." minlength="1" maxlength="50"/>   -->
                                              <textarea  id="name" name="name" class="form-control" required>{{ ( isset($faq->question) ? base64_decode($faq->question) : null) }}</textarea>
                                         </div>
                                      </div>
                                     <div class="row">
                                      <div class="col-sm-3 input_field_sections">
                                            <h5>Description</h5>
                                        </div> 
                                       <div class="col-sm-9 input_field_sections">                                        
                                           <textarea name="description" id="description" class="form-control" required>{{ ( isset($faq->description) ? base64_decode($faq->description) : null) }}</textarea>
                                        </div>
                                        
                                  </div> 
                                    <div class="row"> 
                                       <div class="col-sm-3 input_field_sections">
                                          <h5>Status</h5>
                                        </div>
                                        <div class="col-sm-9 input_field_sections">
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($faq->status) && $faq->status==0)  ? 'selected': '' }}>InActive</option>
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
  CKEDITOR.replace( 'name');
</script>  
 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>


<script type="text/javascript">
  
$( document ).ready(function() {
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z ]+$/i.test(value);
}, "<span class='testing' style='color:red'>  Please enter only letters</span>");

});
$(document).ready(function(){

            $("#adforms").validate(
            {
                ignore: [],
              debug: false,
                rules: { 


                    name:{
                         required: function() 
                        {
                         CKEDITOR.instances.name.updateElement();
                        },
                        minlength:3
                        
                    },
                    description:{
                         required: function() 
                        {
                         CKEDITOR.instances.description.updateElement();
                        },
                         minlength:3
                        
                    }
                },
                messages:
                    {

                    name:{
                        required:"Please enter Text",
                     


                    },
                     description:{
                        required:"Please enter Text",
                      


                    }
                }
            });
        });

$("#cancelform").click(function() {
   window.location.href = "{{url('/faq')}}";
});

</script>



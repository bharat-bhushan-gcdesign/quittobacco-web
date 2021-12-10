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
                               @if(isset($motivation))
                                Add Motivation
                               @else
                                Edit Motivation
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
                                   <a href="{{url('/motivations')}}">Motivation</a>
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
                               @if(isset($motivation))
                    <form method="POST" id="titleforms" name="motivation" action="{{ route('motivations.update',['motivation'=>$motivation->code]) }}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{$motivation->id}}">
                @else
                    <form method="POST" action="{{ route('motivations.store') }}" accept-charset="UTF-8" id="motivationforms" name="motivation" class="form-horizontal" enctype="multipart/form-data">
                @endif
                                          {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                    
                                       <div class="col-sm-6 input_field_sections">
                                            <h5>Message</h5>
                                           <input type="text" class="form-control" name="message" id="message" value="{{ old('message', isset($motivation->message) ? $motivation->message : null) }}" placeholder="Enter Message here.."  onkeypress="return lettersOnly(event)"/>
                                           
                                         </div>


                                       <div class="col-sm-6 input_field_sections">
                                          <h5>Status</h5>
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($motivation->status) && $motivation->status==0)  ? 'selected': '' }}>InActive</option>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script language="javascript">

$(function() {
  
   $( "#titleforms" ).validate({
       rules: {
            message: {
             required: true,
                }, 
        },
       messages: {
        message: {
            required: "Please Enter Message",
                 },

                   }
   });  
});
$("#cancelform").click(function() {
       window.location.href = "{{url('/motivations')}}";
   }); 
 
</script>

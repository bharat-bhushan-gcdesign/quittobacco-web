@include('header')
@include('sidebar')
<!-- /#left -->
        <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar">
                   <div class="row no-gutters">
                       <div class="col-sm-5 col-lg-6 skin_txt">
                           <h4 class="nav_top_align">
                               <i class="fa fa-eye"></i>
                               View FAQ
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
                    <div class="row">
                      <div class="col-sm-12" style="margin-bottom: 15px;">
                        <button  class="btn pull-right" onclick="goBack()" style="background-color:#949609;right: 50px;
    position: relative;"> Back</button>
                      </div>
                        <div class="col">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div class="row">
                                          <div class="col-sm-3 input_field_sections">
                                            <h5>Question</h5>
                                        </div> 
                                        <div class="col-sm-9 input_field_sections">                                       
                                         <strong>{!!base64_decode($faq->question) !!}</strong>
                                         </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-3 input_field_sections">
                                            <h5>Description</h5>
                                        </div> 
                                          <div class="col-sm-9 input_field_sections">                                      
                                         <strong>{!!base64_decode($faq->description) !!}</strong>
                                         </div>
                                         
                                      </div>
                                       
                                </div>
                            </div>
                        </div>
                    </div>

                  
                   
                   
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
 <script>
function goBack() {
  window.history.back();
}
</script>
<!-- startsec End -->
   @include('footer')
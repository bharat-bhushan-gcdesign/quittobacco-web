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
                            View Tobacco Management
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
                                   <a href="{{url('/tobacco')}}">Tobacco Management</a>
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
                        <a href="{{url('/')}}/tobacco_management/edit" style="background-color: #ed7626;padding: 5px 20px;border-radius: 20px !IMPORTANT;display: none;border: 1px solid #ed7626;color: #fff;" type="button" class="btn float-right">Edit</a>
                      </div>
                        <div class="col">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div class="row">
                                      
                                        <div class="col-sm-6 input_field_sections">
                                            <h5>Name</h5>
                                         <strong>{{$tobacco->name}}</strong>
                                         </div>
                                     
                                         <div class="col-sm-6 input_field_sections">
                                            <h5>Status</h5>
                                              <strong>{{($tobacco->status==1)?'Active':'InActive'}}</strong>
                                           </div>
                                      </div>
                                        <div class="row">
                                        
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

<!-- startsec End -->
   @include('footer')

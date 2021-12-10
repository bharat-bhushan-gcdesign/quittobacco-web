@include('header')
@include('sidebar')
<style type="text/css">
.successmsg {
   color: #fff !important;
   background-color: green !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
}
.errmsg {
  color: #fff !important;
   background-color: #ff8086 !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
}
.successmsg1 {
   color: #fff !important;
   background-color: green !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
   display:none;
}
</style>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-4 col-sm-4">
                            <h4 class="nav_top_align">
                                <i class="fa fa-th"></i>
                               {{$user->firstName}}-{{$user->lastName}} Events
                            </h4>
                        </div>
                        <div class="col-lg-6 col-md-8 col-sm-8">
                            <button  class="btn pull-right" onclick="goBack()" style="background-color:#949609;top: 10px;right: 50px;
    position: relative;"> Back</button>
                        </div>
                    </div>
                </div>
            </header>
                      <div align="center">
                  @if(Session::has('message'))
                   <h4>
                  <p class="alert alert-danger errmsg">{{ Session::get('message') }}</p>
                  </h4>
                  @endif
                  
                  @if (count($errors) > 0)                                  
                  <h4>
                     @foreach ($errors->all() as $error)
                     <p class="alert alert-info successmsg">{{ $error }}</p>
                     @endforeach
                  </h4>
                  @endif
                   <p class="alert alert-info successmsg1 statusupdate">Status Updated Successfully</p>
              </div>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-12 data_tables">
                         
                            <!-- BEGIN EXAMPLE2 TABLE PORTLET-->
                            <div class="card">
                                
                                <div class="card-body m-t-35">
                                  
                                   <div class=" m-t-15">
                                    <table class="table table-striped table-bordered table_res toggle_class" id="sample_6">
                                        <thead>
                                        <tr>
                                              <th>Event Name</th>
                                              <th>Start Date</th>
                                              <th>End Date</th>
                                              <th>Event Status</th>                                            
                                              <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($event as $val)
                                            <tr>
                                            
                                                <td> {{$val->event_name}}</td>
                                                <td> {{$val->start_date}}</td>
                                                <td> {{$val->end_date}}</td>
                                                <td>@if($val->event_status==1)
                                                  <strong><button data-toggle="tooltip" data-placement="top"  class="btn btn-primary btn-xs" style="width:100PX;">
                                                    Current</button></strong>
                                                  @elseif($val->event_status==2)
                                                     <strong><button data-toggle="tooltip" data-placement="top"  class="btn btn-success btn-xs" style="width:100PX;">
                                                    Completed</button></strong>
                                                   @else
                                                     <strong><button data-toggle="tooltip" data-placement="top"  class="btn btn-danger btn-xs" style="width:100PX;">
                                                    Cancel</button></strong>
                                                   @endif
                                                </td>
                                                <td class="nowrap">
                                               
                                                <a data-toggle="tooltip" data-placement="top" title="View" href="{{url('events/view',['id' => $val->id])}}" class="btn btn-info btn-xs">
                                                <i class="fa fa-eye"></i>
                                                </a>

                                                </td>
                                            </tr>
                                              @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                                </div>
                            </div>

                            <!-- END EXAMPLE2 TABLE PORTLET-->
                           
                           
                        </div>
                    </div>
                </div>
                <!-- /.inner -->
            </div>
            <!-- /.outer -->
            <!-- Modal -->
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
        <!-- startsec End -->
    </div>
   
 <script>
function goBack() {
  window.history.back();
}


</script>


		
        @include('footer')



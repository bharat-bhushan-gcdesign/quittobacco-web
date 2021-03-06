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
                                State Management
                            </h4>
                        </div>
                        <div class="col-lg-6 col-md-8 col-sm-8">
                            <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">State</a>
                                </li>
                                
                            </ol>
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
                                    <div class="row">
                                        <div class="col-sm-3">  <div class="btn-group show-hide">
                                             

                                              <a data-toggle="tooltip" data-placement="top" title="Add"  class="btn btn-primary"  href="{{url('state/create')}}" > <i class="fa fa-plus"></i> </a>

                                         </div></div>
                                    

                                    </div>
                                   <div class=" m-t-15">
                                    <table class="table table-striped table-bordered table_res toggle_class" id="sample_6">
                                        <thead>
                                        <tr>
                                            <th>Country Name</th>
                                            <th>State Name</th>
                                            <th>Status</th>
                                            <th style="display:none;">Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($state as $val)
                                            <tr>
                                            
                                                <td> {{$val->country->name}}</td>
                                                <td> {{$val->name}}</td>
                                                 
                                                <td style="display:none;" id="statusval_{{$val->id}}">{{$val->status}}</td>
                                                <td> <input type="checkbox" data-toggle="toggle" data-on="Active" data-off="In Active" data-onstyle="success" data-offstyle="danger" data-size="mini" class="statuschange" id="{{$val->id}}" @if($val->status ==1) checked @endif></td>
                                                <td class="nowrap">
                                                <a data-toggle="tooltip" data-placement="top" title="Edit" href="{{url('state/edit',['id' => $val->id])}}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-pencil"></i>
                                                </a>
                                               <!--  <a data-toggle="tooltip" data-placement="top" title="View" href="{{url('cms/view',['id' => $val->id])}}" class="btn btn-info btn-xs">
                                                <i class="fa fa-eye"></i>
                                                </a> -->
                                                 <a href="#" class="btn btn-danger btn-xs waves-effect waves-light remove-record" data-toggle="modal" data-url="{{URL::to('/statedestroy/'.$val->id) }}" data-id="{{$val->id}}" data-target="#custom-width-modal" title="Delete" data-placement="top">
                                                 <i class="fa fa-trash-o remove-record"></i></a>
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
     <form action="" method="POST" class="remove-record-model">
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                    <h4 class="modal-title" id="custom-width-modalLabel">Delete Record</h4>
                </div>
                <div class="modal-body">
                    <h4>You want to delete this record?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
</form>


		
        @include('footer')
         <script type="text/javascript">
   
   $(document).ready(function(){
   // For A Delete Record Popup
   $('body').on('click', '.remove-record', function (){
      var url = $(this).parent().attr('data-url');
      if(typeof url=="undefined")
     url = $(this).attr('data-url');
      $(".remove-record-model").attr("action",url);
   });

   setTimeout(function () {
    $(".errmsg").hide()
   }, 5000); 

   setTimeout(function () {
    $(".successmsg").hide()
   }, 5000);
     $('body').on('change', '.statuschange', function() {
      var id = this.id;
      var status = $(this).prop('checked');
        $.ajax({
        type : "POST",
        url : "{{ url('/') }}/state/statusupdate",
        data : { "_token": "{{ csrf_token() }}", id:id, status:status},
        beforeSend : function() {
          $(".statusupdate").show().delay(3000).fadeOut();
        },
        success : function(data) 
        { 
        },
      });
    });

});
</script>
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
                              Report
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
                                    <a href="#">Report</a>
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
                        <div class="col">
                            <div class="card">
                                <form method="POST" action="{{url('get_report')}}" id="titleforms" name="edit_country" accept-charset="UTF-8" class="form-inline" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                    
                                       <div class="col-sm-4 input_field_sections">
                                            <h5>Select Report</h5>
                                           <select class="form-control status" style="width: 100%;" name="name" id="name"  >
                                             <option value="user">User</option>
                                             <option value="subscription">Subscription</option>
                                             </select>
                                         </div>

                                       <div class="col-sm-4 input_field_sections">
                                          <h5>Type</h5>
                                             <select class="form-control status" style="width: 100%;" name="type" id="type"  >
                                             <option value="pdf">PDF</option>
                                             <option value="csv">CSV</option>
                                             </select>
                                        </div> 
                                        <div class="col-sm-4 input_field_sections">
                                          <input style="margin-top:22px;" type="submit" class="btn btn-primary" value="Get Report">
                                      </div>   
                                  </div>                                 
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.inner -->
            </div>
            <!-- /.outer -->
            <!-- Modal -->
            <div class="modal fade" id="search_modal" tabindex="-1" role="dialog"
                 aria-hidden="true">
                
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
        url : "{{ url('/') }}/title/statusupdate",
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
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
<!-- /#left -->
        <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar">
                   <div class="row no-gutters">
                       <div class="col-sm-5 col-lg-6 skin_txt">
                           <h4 class="nav_top_align">
                               <i class="fa fa-eye"></i>
                               View Gallery
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
                                   <a href="/service-provider-verifications">Gallery</a>
                               </li>
                             
                           </ol>
                       </div>
                       
                   </div>

                </div>
            </header>
             <div align="center">
        @if (Session::has('message'))
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
        <p class="alert alert-info successmsg1 updateStatus">Status Updated Successfully</p>
    </div>
           <div class="row">
                <div class="col-sm-4 input_field_sections">
                    <button  class="btn pull-right " onclick="goBack()" style="background-color:#949609; position: relative;"> Back</button> 
                </div>
               
                
            </div>
            
            <div class="outer">
                <div class="inner bg-container forms">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4 input_field_sections">
                                            <h4>Thumbnail</h4>
                                               <td class="patient-img">
                                                        @if($gallery->image!=null)
                                                            <div class="single-video mr-5">
                                                                <img width="100px" height="80px"
                                                                    src="{{url('/')}}/uploads/gallery/{{$gallery->image}}" allowfullscreen>
                                                                </img>
                                                            </div>
                                                        @else
                                                            <img src="{{url('/')}}/defaults/video.png" id="profile-img-tag" width="100px" height="80px" name="profile_imaged" />
                                                        @endif

                                                </td>
                                        </div>
                                        <div class="col-sm-4 input_field_sections">
                                            <h4>Title</h4>
                                            <strong>
                                                {{$banner->title}}
                                            </strong>
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

<!-- startsec End --> @include('footer')
<script type="text/javascript">
     function goBack() {
        window.history.back();
    }
   
    $(document).ready(function(){
       
        $('body').on('change', '.statuschange', function() {
            var id = this.id;
            var status = $(this).prop('checked');
            $.ajax({
                type : "POST",
                url : "{{ url('/') }}/galleries/update-status",
                data : { "_token": "{{ csrf_token() }}", id:id, status:status},
                beforeSend : function() {
                    $(".updateStatus").show().delay(3000).fadeOut();
                },
                success : function(data){ 
                },
            });
        });
    });
</script>
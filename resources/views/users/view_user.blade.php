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
                               View User
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
                                   <a href="/users">Users</a>
                               </li>
                             
                           </ol>
                       </div>
                       
                   </div>

                </div>
            </header>
             <button  class="btn pull-right" onclick="goBack()" style="background-color:#949609;right: 50px;
    position: relative;"> Back</button> 
            <div class="outer">
                <div class="inner bg-container forms">
                    <div class="row">
                      <div class="col-sm-12" style="margin-bottom: 15px;">
                        <a href="{{url('/')}}/user/edit/" style="background-color: #ed7626;padding: 5px 20px;border-radius: 20px !IMPORTANT;display: none;border: 1px solid #ed7626;color: #fff;" type="button" class="btn float-right">Edit</a>
                      </div>
                        <div class="col">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 input_field_sections">
                                            <h5>Name</h5>
                                           <strong>{{$users->Name}}</strong>
                                             
                                       </div>
                                       <div class="col-sm-6 input_field_sections">
                                            <h5>Mobile No</h5>
                                              <strong>{{$users->mobile}}</strong>
                                        </div>
                                      </div>
                                        <div class="row">
                                          <div class="col-sm-6 input_field_sections">
                                            <h5>Email</h5>
                                               <strong>{{$users->email}}</strong>
                                           </div>
                                          <div class="col-sm-6 input_field_sections">
                                            <h5>Status</h5>
                                             @if($users->status==1)
                                              <strong>Active</strong>
                                            @else
                                              <strong>Ban</strong>
                                            @endif
                                           </div>
                                    </div>
                                     <!--<div class="row">
                                        <div class="col-sm-6 input_field_sections">
                                            <h5>Photo</h5>
                                             @if(isset($users) && $users->profile_img!="" && $users->profile_img!=null)
                                                                        <img src="{{url('/')}}/uploads/userimage/{{$users->profile_img}}" id="profile-img-tag" width="180px" height="140px"  name="profile_imaged" style="margin-top:15px;"/>
                                                                    @else
                                                                       <img src="{{url('/')}}/uploads/userimage/userdefault.png" id="profile-img-tag" width="180px" height="140px" name="profile_imaged" />
                                                                      @endif
                                                                  
                                           </div>
                                    
                                </div>
                                    
                                     @if($rawvar!="")
                                            <div class="col-sm-6 input_field_sections">
                                            <h5>Cocreator</h5>
                                            @foreach($rawvar as $raw)
                                               <a href="{{url('/')}}/user/view/{{$raw['id']}}"><span style="color:blue;">{{$raw['name']}}</span></a>
                                               <br>
                                                 @endforeach
                                           </div>
                                           @endif
                                   
                            </div>-->
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


<!-- startsec End --> @include('footer')

<style>
    #menu .dropdown_menu .dropdown_menu {
        width: 100%;
        display: block;
        background-color: #444!Important;
    }
    
    #menu .dropdown_menu .dropdown_menu.active {
        width: 100%;
        display: block;
    }
    
    #menu .dropdown_menu .dropdown_menu.active a {
        width: 100%;
        background: #333;
    }
    
    #menu .dropdown_menu .dropdown_menu.active .link-title.menu_hide {
        width: 100%;
        display: block;
    }
    
    #menu .dropdown_menu .dropdown_menu .link-title.menu_hide {
        width: 100%;
        display: inline;
    }
    
    #menu .dropdown_menu .dropdown_menu.active .collapse.show {
        background: #111;
    }
    
    #menu .dropdown_menu .dropdown_menu.active a .fa:before {
        color: #ed7626;
    }
    
    #menu .dropdown_menu .dropdown_menu.active a .fa.arrow:before {
        color: #ed7626;
    }



div#left
{
    overflow: auto;
    height: 100%;
    position: absolute;
    width: 270px;

}

.no-gutters {
    margin-right: 0;
    margin-left: 270px;
}

.outer {
   
    margin-left: 270px;
}

</style>

<!-- start sidebar menu -->
 <?php
                                $url = explode('/', Request::path());
                                ?>

<?php
if(Auth::check())
{
    $allowed = 0;
     $modulesid = array();
    $userdetails =  App\Models\Users::where('id',Auth::user()->id)->first(); 
    if(is_object($userdetails))
    {
        if($userdetails->user_type_id ==1)
        $allowed = 1;
        if($userdetails->user_type_id ==2)
        {
            $permissionmodules = App\Models\Userpermissions::where('user_id',$userdetails->id)->get();
            if(count($permissionmodules) > 0) 
            {
                foreach ($permissionmodules as $permission_modules) {
                    $modulesid[] = $permission_modules->module_id;
                }
            }
        }
    }
    $profileimage = ($userdetails->profile_img!=null) ? $userdetails->profile_img : "defaultprofile.jpg";
    $name = ($userdetails->name!="") ? $userdetails->name : "User";
    $role = ($userdetails->user_type_id=="1") ? "Administrator" : "Sub Admin";
}
?>
    @if(Auth::check())
    <div id="left">
        <div class="menu_scroll">
            <div class="left_media">
                <div class="media user-media">
                    <div class="user-media-toggleHover">
                        <span class="fa fa-user"></span>
                    </div>
                    <div class="user-wrapper" style="width:100%">
                        <a class="user-link" href="{{url('/')}}/editprofile/{{$userdetails->id}}">
                            <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture" src="{{url('/')}}/uploads/userimage/{{$profileimage}}">
                            <p class="user-info menu_hide" style="display: inline-block;width: 164px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">Welcome cvbvc{{$name}}</p>
                            <div class="roal_abso">
                                <p class="user-info role">{{$role}}</p>
                            </div>
                        </a>
                    </div>
                </div>
                <hr/>
            </div>
            <ul id="menu">
                @if($allowed ==1)
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'admin')?'active':'' }}  ">
                    <a href="{{url('/')}}/admin">
                        <i class="fa fa-user-secret"></i>
                        <span class="link-title menu_hide">&nbsp;Admins</span>
                    </a>
                </li>
                @endif @if($allowed ==1 || in_array(11,$modulesid))
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'subadmin')?'active':'' }}  ">
                    <a href="{{url('/')}}/subadmin">
                        <i class="fa fa-user-secret"></i>
                        <span class="link-title menu_hide">&nbsp;Sub Admins</span>
                    </a>
                </li>
                @endif @if($allowed ==1 || in_array(1,$modulesid))
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'users')?'active':'' }}  ">
                    <a href="{{url('/')}}/users">
                        <i class="fa fa-users"></i>
                        <span class="link-title menu_hide">&nbsp;User Management </span>
                    </a>
                </li>
                @endif @if($allowed ==1 || in_array(15,$modulesid))
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'orders')?'active':'' }}  ">
                    <a href="{{url('/')}}/orders">
                        <i class="fa fa-money"></i>
                        <span class="link-title menu_hide">&nbsp;Order Management </span>
                    </a>
                </li>
                @endif @if($allowed ==1 || in_array(2,$modulesid))
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'airport')?'active':'' }}  ">
                    <a href="{{url('/')}}/airport">
                        <i class="fa fa-plane"></i>
                        <span class="link-title menu_hide">&nbsp;Airport Management</span>
                    </a>
                </li>
                @endif @if($allowed ==1 || in_array(6,$modulesid))
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'terminal')?'active':'' }}  ">
                    <a href="{{url('/')}}/terminal">
                        <i class="fa fa-road"></i>
                        <span class="link-title menu_hide">&nbsp;Terminal Management</span>
                    </a>
                </li>
                @endif @if($allowed ==1 ||in_array(3,$modulesid) || in_array(4,$modulesid) || in_array(5,$modulesid)|| in_array(10,$modulesid)|| in_array(13,$modulesid)|| in_array(14,$modulesid))
                <li class="dropdown_menu {{ (isset($url[0]) &&  $url[0] == 'restaurants' || $url[0] == 'restaurantmenucategory' || $url[0] == 'restaurantmenu' || $url[0] == 'restauranttype' || $url[0] == 'foodtype' || $url[0] == 'servicetype' || $url[0] == 'retailtype' || $url[0] == 'retailshop' ||  $url[0] == 'offertype' || $url[0] == 'offer' || $url[0] == 'vehicle' || $url[0] == 'lounge' || $url[0] == 'facility')?'active':'' }} ">
                    <a href="#">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp; Service  Management</span>
                        <span class="fa arrow menu_hide"></span>
                    </a>
                    <ul class="{{ (isset($url[0]) &&  $url[0] == 'restaurants' || $url[0] == 'restaurantmenucategory' || $url[0] == 'restaurantmenu' || $url[0] == 'restauranttype' || $url[0] == 'foodtype' || $url[0] == 'servicetype' || $url[0] == 'retailtype' || $url[0] == 'retailshop' ||  $url[0] == 'offertype' || $url[0] == 'offer' || $url[0] == 'vehicle' || $url[0] == 'lounge' || $url[0] == 'facility')?'show':'' }}">

                        <!--new one for restaturant-->

                        @if($allowed ==1 || in_array(3,$modulesid))
                        <li class="dropdown_menu {{ (isset($url[0]) &&  $url[0] == 'restaurants' || $url[0] == 'restaurantmenucategory' || $url[0] == 'restaurantmenu' || $url[0] == 'restauranttype' || $url[0] == 'foodtype' || $url[0] == 'servicetype')?'active':'' }}">
                            <a href="#">
                                <i class="fa fa-cutlery"></i>
                                <span class="link-title menu_hide">&nbsp; Eats and Drinks</span>
                                <span class="fa arrow menu_hide"></span>
                            </a>
							<ul class="{{ (isset($url[0]) &&  $url[0] == 'restaurants' || $url[0] == 'restaurantmenucategory' || $url[0] == 'restaurantmenu' || $url[0] == 'restauranttype' || $url[0] == 'foodtype' || $url[0] == 'servicetype')?'show':'' }} ">
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'restaurants')?'active':'' }}">
                                    <a href="{{url('/')}}/restaurants"> Eats and Drinks </a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'restaurantmenucategory')?'active':'' }}">
                                    <a href="{{url('/')}}/restaurantmenucategory"> Menu Category </a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'restaurantmenu')?'active':'' }}">
                                    <a href="{{url('/')}}/restaurantmenu"><span class="link-title menu_hide">Menu Item</span></a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'restauranttype')?'active':'' }}">
                                    <a href="{{url('/')}}/restauranttype"><span class="link-title menu_hide">Restaurant Type</span></a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'foodtype')?'active':'' }}">
                                    <a href="{{url('/')}}/foodtype"><span class="link-title menu_hide">Food Type</span></a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'servicetype')?'active':'' }}">
                                    <a href="{{url('/')}}/servicetype">Service Type</a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'owner')?'active':'' }}">
                                    <a href="{{url('/')}}/owner">Restaurant Manager</a>
                                </li>
                            </ul>
                        </li>

                        @endif

                        <!--new one end-->


                        <!--new one for shop-->

                        @if($allowed ==1 || in_array(13,$modulesid))
                        <li class="dropdown_menu {{ (isset($url[0]) &&  $url[0] == 'retailtype' || $url[0] == 'retailshop')?'active':'' }}">
                            <a href="#">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="link-title menu_hide">&nbsp; Shop</span>
                                <span class="fa arrow menu_hide"></span>
                            </a>
                            <ul class="{{ (isset($url[0]) &&  $url[0] == 'retailtype' || $url[0] == 'retailshop')?'show':'' }}">
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'retailtype')?'active':'' }}">
                                    <a href="{{url('/')}}/retailtype">Shop Type</a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'retailshop')?'active':'' }}">
                                    <a href="{{url('/')}}/retailshop">Shop</a>
                                </li>
                            </ul>
                        </li>

                        @endif @if($allowed ==1 || in_array(5,$modulesid))
                        <li class="dropdown_menu {{ (isset($url[0]) &&  $url[0] == 'offertype' || $url[0] == 'offer')?'active':'' }}">
                            <a href="#">
                                <i class="fa fa-gift"></i>
                                <span class="link-title menu_hide">&nbsp; Offer</span>
                                <span class="fa arrow menu_hide"></span>
                            </a>
                            <ul class="{{ (isset($url[0]) &&  $url[0] == 'offertype' || $url[0] == 'offer')?'show':'' }}">
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'offertype')?'active':'' }}">
                                    <a href="{{url('/')}}/offertype">Offer Type</a>
                                </li>
                                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'offer')?'active':'' }}">
                                    <a href="{{url('/')}}/offer">Offer</a>
                                </li>
                            </ul>
                        </li>
                        @endif

						<!--new one for transport-->
                        @if($allowed ==1 || in_array(14,$modulesid))
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'vehicle')?'active':'' }}">
                            <a href="{{url('/')}}/vehicle">
                                <i class="fa fa-bus"></i> &nbsp;Transport Management
                            </a>
                        </li>
                        @endif
                        <!--new one end-->

                         @if($allowed ==1 || in_array(4,$modulesid))
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'lounge')?'active':'' }}">
                            <a href="{{url('/')}}/lounge">
                                <i class="fa fa-recycle"></i> &nbsp;Facility Management
                            </a>
                        </li>
                        @endif @if($allowed ==1 || in_array(10,$modulesid))
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'facility')?'active':'' }}">
                            <a href="{{url('/')}}/facility">
                                <i class="fa fa-bookmark"></i>
                                <span class="link-title menu_hide">&nbsp;Amenities Management</span>
                            </a>
                        </li>
                        @endif
                        <!--new one end-->
                    </ul>
                </li>
                @endif 

                @if($allowed ==1 || in_array(16,$modulesid))
                <li class="dropdown_menu {{ (isset($url[0]) &&  $url[0] == 'order_review' || $url[0] == 'trip_review')?'active':'' }}">
                    <a href="#">
                        <i class="fa fa-star"></i>
                        <span class="link-title menu_hide">&nbsp; Review Management</span>
                        <span class="fa arrow menu_hide"></span>
                    </a>
                    <ul class="{{ (isset($url[0]) &&  $url[0] == 'order_review' || $url[0] == 'order_review')?'show':'' }}">
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'order_review')?'active':'' }}">
                            <a href="{{url('/')}}/order_review">Order Reviews</a>
                        </li>
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'trip_review')?'active':'' }}">
                            <a href="{{url('/')}}/trip_review">Trip Reviews</a>
                        </li>
                    </ul>
                </li>
                @endif 

                @if($allowed ==1 || in_array(9,$modulesid))
                <li class="dropdown_menu {{ (isset($url[0]) &&  $url[0] == 'advertisement' || $url[0] == 'news' || $url[0] == 'cms' || $url[0] == 'tips')?'active':'' }}">
                    <a href="#">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp; CMS</span>
                        <span class="fa arrow menu_hide"></span>
                    </a>
                    <ul class=" {{ (isset($url[0]) &&  $url[0] == 'advertisement' || $url[0] == 'news' || $url[0] == 'cms' || $url[0] == 'tips')?'show':'' }}">
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'advertisement')?'active':'' }}">
                            <a href="{{url('/')}}/advertisement"> Advertising</a>
                        </li>
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'news')?'active':'' }}">
                            <a href="{{url('/')}}/news"> News List</a>
                        </li>
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'cms')?'active':'' }}">
                            <a href="{{url('/cms')}}"> Content Management</a>
                        </li>
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'tips')?'active':'' }}">
                            <a href="{{url('/tips')}}"> Tips Management</a>
                        </li>
                    </ul>
                </li>
                @endif @if($allowed ==1)
                <li class="dropdown_menu {{ (isset($url[0]) &&  $url[0] == 'country' || $url[0] == 'state' || $url[0] == 'city' || $url[0] == 'currency')?'active':'' }}">
                    <a href="#">
                        <i class="fa fa-tasks"></i>
                        <span class="link-title menu_hide">&nbsp; General</span>
                        <span class="fa arrow menu_hide"></span>
                    </a>
                    <ul class="{{ (isset($url[0]) &&  $url[0] == 'country' || $url[0] == 'state' || $url[0] == 'city' || $url[0] == 'currency')?'show':'' }}">
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'country')?'active':'' }}">
                            <a href="{{url('/')}}/country">Country</a>
                        </li>
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'state')?'active':'' }}">
                            <a href="{{url('/')}}/state">State</a>
                        </li>
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'city')?'active':'' }}">
                            <a href="{{url('/city')}}">City</a>
                        </li>
                        <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'currency')?'active':'' }}">
                            <a href="{{url('/currency')}}">Currency</a>
                        </li>
                    </ul>
                </li>
                @endif @if($allowed ==1)
                {{--<li>
                    <a href="#">
                        <i class="fa fa-credit-card"></i>
                        <span class="link-title menu_hide">&nbsp;Payment Reports</span>
                    </a>
                </li>--}}
                @endif

            </ul>
            <!-- /#menu -->
        </div>
    </div>
    <!-- end sidebar menu -->
    @endif
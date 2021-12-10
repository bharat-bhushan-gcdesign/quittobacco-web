

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
    $userdetails =  App\User::where('id',Auth::user()->id)->first(); 
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
    $profileimage = ($userdetails->profile_image!=null) ? $userdetails->profile_image : "defaultprofile.jpg";
    $name = ($userdetails->name!="") ? $userdetails->name : "User";
    //$role = ($userdetails->user_type=="1") ? "Administrator" : "Sub Admin";
    $role = "Admin";
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
                        <a class="user-link" href="{{url('/')}}/editprofile/{{$userdetails->code}}">
                            @if($userdetails->profile!=null)
                                <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture" src="{{url('/')}}/uploads/files/{{$userdetails->profile->name}}" onerror="this.onerror=null; this.src='{{url('/')}}/uploads/dummy/userdefault.png'">
                            @else
                               <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture" src="{{url('/')}}/uploads/dummy/userdefault.png">
                            @endif
                            
                            <p class="user-info menu_hide" style="display: inline-block;width: 164px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">{{$name}}</p>
                            <div class="roal_abso">
                                <p class="user-info role">{{$role}}</p>
                            </div>
                        </a>
                    </div>
                </div>
                <hr/>
            </div>



<!-- /********************** Implemented by Jemima Starts ***************/  -->
    <!-- /** Dashboard  -->

           <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'home')?'active':'' }}  ">
                    <a href="{{url('home')}}" title="Home">
                        <i class="fa fa-home"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Dashboard
                        </span>
                    </a>
                </li>
            </ul>


    <!-- /** User  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'users')?'active':'' }}  ">
                    <a href="{{route('users.index')}}" title="User">
                        <i class="fa fa-user"></i>
                        <span class="link-title menu_hide">
                            &nbsp;User
                        </span>
                    </a>
                </li>
            </ul>


    <!-- /** Education */  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'educations')?'active':'' }}  ">
                    <a href="{{route('educations.index')}}" title="Education">
                        <i class="fa fa-graduation-cap"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Education
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Tobaccco - type of tobacco */  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'tobaccos')?'active':'' }}  ">
                    <a href="{{route('tobaccos.index')}}" title="Tobacco Types">
                        <i class="fa fa-comments"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Tobaccco
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Tobaccco Product- type of tobacco products*/  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'tobacco-products')?'active':'' }}  ">
                    <a href="{{route('tobacco_products.index')}}" title="Tobacco Product Types">
                        <i class="fa fa-comments"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Tobaccco Product 
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** First Smoke Timing - first smoke after wake up*/  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'first-smoke-timings')?'active':'' }}  ">
                    <a href="{{route('first_smoke_timings.index')}}" title="First Smoke Timing after wake up">
                        <i class="fa fa-clock-o"></i>
                        <span class="link-title menu_hide">
                            &nbsp;First Smoke Timing
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Use Reason - Why use tobacco*/  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'use-reasons')?'active':'' }}  ">
                    <a href="{{route('use_reasons.index')}}" title="Use Reason - Why use tobacco">
                        <i class="fa fa-comments"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Use Reason
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Quit Reason - Reason to quit tobacco */  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'quit-reasons')?'active':'' }}  ">
                    <a href="{{route('quit_reasons.index')}}" title="Quit Reason - Reason to quit tobacco">
                        <i class="fa fa-comments"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Quit Reason
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Profession - what do you do*/  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'professions')?'active':'' }}  ">
                    <a href="{{route('professions.index')}}" title="What do you do">
                        <i class="fa fa-graduation-cap"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Profession
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Frequent Smoke - How often smoke*/  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'frequent-smokes')?'active':'' }}  ">
                    <a href="{{route('frequent_smokes.index')}}" title="How often you Smoke">
                        <i class="fa fa-comments" ></i>
                        <span class="link-title menu_hide">
                            &nbsp;Frequent Smoke
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Currency */  -->

           <!--  <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'currencies')?'active':'' }}  ">
                    <a href="{{route('currencies.index')}}" title="Currency">
                        <i class="fa fa-graduation-cap"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Currency
                        </span>
                    </a>
                </li>
            </ul> -->

    <!-- /** Feeling - How are you feeling */  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'feelings')?'active':'' }}  ">
                    <a href="{{route('feelings.index')}}" title="How are you Feeling">
                        <i class="fa fa-smile-o"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Feeling
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Doing - What are you doing */  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'doings')?'active':'' }}  ">
                    <a href="{{route('doings.index')}}" title="What are you Doing">
                        <i class="fa fa-tasks"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Doing
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** With Whom - Whom you are with */  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'with-whoms')?'active':'' }}  ">
                    <a href="{{route('with_whoms.index')}}" title="Whom you are with">
                        <i class="fa fa-users"></i>
                        <span class="link-title menu_hide">
                            &nbsp;With Whom
                        </span>
                    </a>
                </li>
            </ul>

    

    <!-- /** User Detail */  -->

            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'user-details')?'active':'' }}  ">
                    <a href="{{route('user_details.index')}}" title="User Detail">
                        <i class="fa fa-user"></i>
                        <span class="link-title menu_hide">
                            &nbsp;User Detail
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Subscription Management  */ -->
            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'subscriptions')?'active':'' }}  ">
                    <a href="{{route('subscriptions.index')}}" title="Subscription">
                        <i class="fa fa-credit-card"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Subscription
                        </span>
                    </a>
                </li>
            </ul>

        <!-- /** Cron Job - Cron For Notification */  -->

           <!--  <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'cron-jobs')?'active':'' }}  ">
                    <a href="{{route('cron_jobs.index')}}" title="Cron For Notification">
                        <i class="fa fa-tasks"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Cron Job
                        </span>
                    </a>
                </li>
            </ul> -->

    <!-- /** CMS Management - Contents */ -->
            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'contents')?'active':'' }}  ">
                    <a href="{{route('contents.index')}}" title="CMS">
                        <i class="fa fa-file"></i>
                        <span class="link-title menu_hide">
                            &nbsp;CMS
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** CRAVING VIDEOS */ -->
            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'contents')?'active':'' }}  ">
                    <a href="{{route('carving_videos.index')}}" title="CMS">
                        <i class="fa fa-file"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Craving Videos
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Motivations */ -->
            <!-- <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'contents')?'active':'' }}  ">
                    <a href="{{route('motivations.index')}}" title="CMS">
                        <i class="fa fa-file"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Motivations
                        </span>
                    </a>
                </li>
            </ul> -->

    <!-- /** Static Notification */ -->
            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'contents')?'active':'' }}  ">
                    <a href="{{route('static_notifications.index')}}" title="CMS">
                        <i class="fa fa-file"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Static Notifications
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Quit Benefit Management - Benefits of quiting Tobacco */ -->
            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'quit-benefits')?'active':'' }}  ">
                    <a href="{{route('quit_benefits.index')}}" title="Quit Benefit">
                        <i class="fa fa-plus-square"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Quit Benefit
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Slider Management - App splash screen splider */ -->
            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'sliders')?'active':'' }}  ">
                    <a href="{{route('sliders.index')}}" title="Slider">
                        <i class="fa fa-sliders"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Slider
                        </span>
                    </a>
                </li>
            </ul>

    <!-- /** Feedback Management  */ -->
            <ul id="menu">
                <li class="nav-item {{ (isset($url[0]) &&  $url[0] == 'feedbacks')?'active':'' }}  ">
                    <a href="{{route('feedback.index')}}" title="Feedback">
                        <i class="fa fa-comments"></i>
                        <span class="link-title menu_hide">
                            &nbsp;Feedback
                        </span>
                    </a>
                </li>
            </ul>

<!-- /********************** Implemented by Jemima Ends ***************/  -->











           <!-- <ul id="menu">
             
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'city')?'active':'' }}  ">
                    <a href="{{url('/')}}/city">
                        <i class="fa fa-home"></i>
                        <span class="link-title menu_hide">&nbsp;City Management </span>
                    </a>
                </li>
                 
            </ul>
             <ul id="menu">
             
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'specialist')?'active':'' }}  ">
                    <a href="{{url('/')}}/specialist">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp;Specialist Management </span>
                    </a>
                </li>
                 
            </ul> -->
             <!-- 
             <ul id="menu">
             
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'bankdetails')?'active':'' }}  ">
                    <a href="{{url('/')}}/bankdetails">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp;Bank Details  </span>
                    </a>
                </li>
                 
            </ul>
            <ul id="menu">
             
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'events')?'active':'' }}  ">
                    <a href="{{url('/')}}/events">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp;Event Management </span>
                    </a>
                </li>
                 
            </ul>  
            <ul id="menu">
             
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'relationship')?'active':'' }}  ">
                    <a href="{{url('/')}}/relationship">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp;Relationship Management </span>
                    </a>
                </li>
                 
            </ul>

              <ul id="menu">
             
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'faq')?'active':'' }}  ">
                    <a href="{{url('/')}}/faq">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp;FAQ</span>
                    </a>
                </li>
                 
            </ul>
             <ul id="menu">
             
                <li class="nav-item  {{ (isset($url[0]) &&  $url[0] == 'title')?'active':'' }}  ">
                    <a href="{{url('/')}}/title">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="link-title menu_hide">&nbsp;Title</span>
                    </a>
                </li>
                 
            </ul> -->
            <!-- /#menu -->
        </div>
    </div>
    <!-- end sidebar menu -->
    @endif

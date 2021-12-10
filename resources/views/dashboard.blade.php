@include('header')
@include('sidebar')
<body onload="initFirebaseMessagingRegistration();">

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- /#left -->
<div id="content" class="bg-container" style="min-height:600px;">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Dashboard
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row widget_countup">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div id="top_widget11" class="minset">
                        <div class="front">
                            <div class="bg-primary bg-cmn p-d-15 b_r_5">
                                <a href="{{url('/users')}}" style="outline: none;">
                                    <div class="float-right m-t-5">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div id="widget_countup">
                                        <h1>{{$users['total']}}</h1>
                                    </div>
                                    <h5><p>
                                        <span>
                                            Active Users- {{$users['active']}}
                                        </span><p>
                                        <span>
                                            InActive Users- {{$users['inactive']}}
                                        </span><p>
                                        <span>
                                            SocialMedia Users - {{$users['social_media_users']}}
                                        </span><p>
                                    </h5>
                                    <div class="previous_font">
                                        <h4>Customer</h4>
                                    </div>
                                </a>
                            </div>
                        </div>                      
                    </div>
                </div>     
                <!-- <div class="col-12 col-sm-6 col-xl-3">
                    <div id="top_widget11" class="minset">
                        <div class="front">
                            <div class="bg-primary bg-cmn p-d-15 b_r_5">
                                <a href="{{url('/subscriptions')}}" style="outline: none;">
                                    <div class="float-right m-t-5">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div id="widget_countup">
                                        <h1>{{$users['total']}}</h1>
                                    </div>
                                    <h5><p>
                                        <span>
                                            Free - {{$users['free']['amount']}}
                                        </span><p>
                                        <span>
                                            Platinum - {{$users['gold']['amount']}}
                                        </span><p>
                                        <span>
                                            Gold - {{$users['platinum']['amount']}}
                                        </span>

                                    </h5>
                                    <div class="previous_font">
                                        <h4>Subscription</h4>
                                    </div>
                                </a>
                            </div>
                        </div>                      
                    </div>
                </div>    -->
            </div>
            <div class="row" style="margin-top: 20px;">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
                <div class="col-lg-6 col-md-12" style="margin-top: 20px;"><canvas id="chart2" height="200"></canvas></div>
                <div class="col-lg-6 col-md-12" style="margin-top: 20px;"><canvas id="chart3" height="200"></canvas></div>
               
                <script type="text/javascript">
                  // Bar chart
                    new Chart(document.getElementById("chart2"), {
                        type: 'bar',
                        data: {
                            labels: [
                                "Free",
                                "Platinum",
                                "Gold"
                            ],
                            datasets: [
                                {
                                    label: "Total",
                                    backgroundColor: ["#1d5b99", "#1d5b99","#1d5b99"],
                                    data: [
                                        {{$users['free']['amount']}},
                                        {{$users['gold']['amount']}},
                                        {{$users['platinum']['amount']}}
                                    ]
                                }
                            ]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Subscription'
                            }
                        }
                    });
                  

                    new Chart(document.getElementById("chart3"), {
                        type: 'pie',
                        data: {
                            labels: [
                                "SocialMedia Users",
                                "Active Users",
                                "Inactive Users"
                            ],
                            datasets: [{
                                label: "count (millions)",
                                backgroundColor: ["#1d5b99", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                data: [
                                    "{{$users['social_media_users']}}",
                                    "{{$users['active']}}",
                                    "{{$users['inactive']}}"
                                ]
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: 'Users'
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
    <!--top section widgets-->
    <div class="row widget_countup">
          
    </div>
</div>

@include('footer')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SACCO And Investment Club Management System">
    <meta name="author" content="Nexen Technologies LTD">
    <link rel="shortcut icon" href="{{URL::asset('assets/images/e-fav.ico')}}">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <!--Core CSS -->
    <link href="{{URL::asset('assets/bs3/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/js/jvector-map/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/clndr.css')}}" rel="stylesheet">
    <!--clock css-->
    <link href="{{URL::asset('assets/js/css3clock/css/style.css')}}" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{URL::asset('assets/js/morris-chart/morris.css')}}">
    <!-- Custom styles for this template -->
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/style-responsive.css')}}" rel="stylesheet"/>

    @section('page_styles')
    @show
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix noprint">
    <!--logo start-->
    <div class="brand">

        <a href="index.html" class="logo">
            <img src="{{URL::asset('assets/images/system-logo.png')}}" alt="">
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->

    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-tasks"></i>
                    <span class="badge bg-success">8</span>
                </a>
                <ul class="dropdown-menu extended tasks-bar">
                    <li>
                        <p class="">You have 8 pending tasks</p>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Target Sell</h5>
                                    <p>25% , Deadline  12 June’13</p>
                                </div>
                                        <span class="notification-pie-chart pull-right" data-percent="45">
                                <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Product Delivery</h5>
                                    <p>45% , Deadline  12 June’13</p>
                                </div>
                                        <span class="notification-pie-chart pull-right" data-percent="78">
                                <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Payment collection</h5>
                                    <p>87% , Deadline  12 June’13</p>
                                </div>
                                        <span class="notification-pie-chart pull-right" data-percent="60">
                                <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Target Sell</h5>
                                    <p>33% , Deadline  12 June’13</p>
                                </div>
                                        <span class="notification-pie-chart pull-right" data-percent="90">
                                <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="external">
                        <a href="#">See All Tasks</a>
                    </li>
                </ul>
            </li>
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <li id="header_inbox_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-important">4</span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <li>
                        <p class="red">You have 4 Mails</p>
                    </li>
                    <li>
                        <a href="#">
                            <span class="photo"><img alt="avatar" src="{{URL::asset('assets/images/avatar-mini.jpg')}}"></span>
                                    <span class="subject">
                                    <span class="from">Jonathan Smith</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hello, this is an example msg.
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="photo"><img alt="avatar" src="{{URL::asset('assets/images/avatar-mini-2.jpg')}}"></span>
                                    <span class="subject">
                                    <span class="from">Jane Doe</span>
                                    <span class="time">2 min ago</span>
                                    </span>
                                    <span class="message">
                                        Nice admin template
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="photo"><img alt="avatar" src="{{URL::asset('assets/images/avatar-mini-3.jpg')}}"></span>
                                    <span class="subject">
                                    <span class="from">Tasi sam</span>
                                    <span class="time">2 days ago</span>
                                    </span>
                                    <span class="message">
                                        This is an example msg.
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="photo"><img alt="avatar" src="{{URL::asset('assets/images/avatar-mini.jpg')}}"></span>
                                    <span class="subject">
                                    <span class="from">Mr. Perfect</span>
                                    <span class="time">2 hour ago</span>
                                    </span>
                                    <span class="message">
                                        Hi there, its a test
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">See all messages</a>
                    </li>
                </ul>
            </li>
            <!-- inbox dropdown end -->
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                    <i class="fa fa-bell-o"></i>
                    <span class="badge bg-warning">3</span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <li>
                        <p>Notifications</p>
                    </li>
                    <li>
                        <div class="alert alert-info clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #1 overloaded.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-danger clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #2 overloaded.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-success clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #3 overloaded.</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </li>
            <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
    </div>
    
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search">
            </li>
            <!-- user login dropdown start-->
            <!-- <li class="dropdown"> -->
                <!-- <a data-toggle="dropdown" class="dropdown-toggle" href="#"> -->
                    <!-- <img alt="" src="{{URL::asset('assets/images/avatar1_small.jpg')}}"> -->
                    <!-- <span class="username">John Doe</span> -->
                    <!-- <b class="caret"></b> -->
                <!-- </a> -->
                <!-- <ul class="dropdown-menu extended logout"> -->
                    <!-- <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li> -->
                    <!-- <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li> -->
                    <!-- <li><a href="login.html"><i class="fa fa-key"></i> Log Out</a></li> -->
                <!-- </ul> -->
            </li>
            <li class="dropdown">
                <a id="navbarDropdown" class="dropdown-toggle" href="#" data-toggle="dropdown" >
                    <img alt="" src="{{URL::asset('assets/images/no-avatar.jpg')}}">
                    <span class="username">{{ Auth::user()->name }}</span> 
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"><i class="fa fa-key"></i>{{ __('Logout') }}</a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->

<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse noprint">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <!-- class active -->
                    <a  href="{{URL::to('/')}}/">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-users"></i>
                        <span>Members</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/')}}/member/new">New Member</a></li>
                        <li><a href="{{URL::to('/')}}/members">Members</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-laptop"></i>
                        <span>Loans</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/')}}/all/loans">All Loans</a></li>
                        <li><a href="{{URL::to('/')}}/active/loans">Active Loans</a></li>
                        <li><a href="{{URL::to('/')}}/arrear/loans">Loans in Arrea</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Groups</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/')}}/group/new">New Group</a></li>
                        <li><a href="{{URL::to('/')}}/groups">Group List</a></li>
                        <li><a href="{{URL::to('/')}}/portfolio/group">Group Portfolio</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user"></i>
                        <span>Employees</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/')}}/employee/new">New Employee</a></li>
                        <li><a href="{{URL::to('/')}}/employees">Employees</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/')}}/reports/annual">Annual</a></li>
                        <li><a href="{{URL::to('/')}}/reports/monthly">Monthly</a></li>
                        <li><a href="{{URL::to('/')}}/reports/weekly">Weekly</a></li>
                        <li><a href="{{URL::to('/')}}/reports/thisweek">This Week</a></li>
                        <li><a href="{{URL::to('/')}}/reports/par">Portifolio at Risk</a></li>
                        <!-- <li><a href="#widget.html">Daily</a></li> -->
                    </ul>
                </li>
                <li>
                    <!-- class active -->
                    <a  href="{{URL::to('/')}}/collection-sheet">
                        <i class="fa fa-book"></i>
                        <span>Collection Sheet</span>
                    </a>
                </li>            
                {{--<li class="sub-menu">
                    <a href="javascript:;">
                        <i class=" fa fa-bar-chart-o"></i>
                        <span>Charts</span>
                    </a>
                    <ul class="sub">
                        <li><a href="#morris.html">Morris</a></li>
                        <li><a href="#chartjs.html">Chartjs</a></li>
                        <li><a href="#flot_chart.html">Flot Charts</a></li>
                        <li><a href="#c3_chart.html">C3 Chart</a></li>
                    </ul>
                </li>                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-glass"></i>
                        <span>Extra</span>
                    </a>
                    <ul class="sub">
                        <li><a href="#lock_screen.html">Lock Screen</a></li>
                        <li><a href="#profile.html">Profile</a></li>                        
                        <li><a href="#timeline.html">Timeline</a></li>                    
                        <li><a href="#gallery.html">Media Gallery</a></li><li><a href="404.html">404 Error</a></li>
                        <li><a href="#500.html">500 Error</a></li>                        
                    </ul>
                </li>--}}                
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
@section('body')
    @show
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src="{{URL::asset('assets/js/jquery.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-1.8.3.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.js')}}"></script>
<script src="{{URL::asset('assets/bs3/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.scrollTo.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{URL::asset('assets/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{URL::asset('assets/js/skycons/skycons.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.scrollTo/jquery.scrollTo.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script> <!-- need this locally -->
<script src="{{URL::asset('assets/js/calendar/clndr.js')}}"></script>
<script src="{{URL::asset('assets/js/underscore-min.js')}}"></script>
<script src="{{URL::asset('assets/js/calendar/moment-2.2.1.js')}}"></script>
<script src="{{URL::asset('assets/js/evnt.calendar.init.js')}}"></script>

<script src="{{URL::asset('assets/js/jquery.customSelect.min.js')}}" ></script>
<!--common script init for all pages-->
<script src="{{URL::asset('assets/js/scripts.js')}}"></script>
<!--script for this page-->
@section('page_script')
    @show
</body>
</html>
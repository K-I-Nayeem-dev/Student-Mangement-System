@php
use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Riho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Riho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('dashboard_assests') }}/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://www.vidyalayaschoolsoftware.com/webassets/images/call_action.svg"
        type="image/x-icon">
    <title>Student Management System</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="../../css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/echart.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/date-picker.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/style.css">
    <link id="color" rel="stylesheet" href="{{ asset('dashboard_assests') }}/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assests') }}/css/responsive.css">
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader4"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                    placeholder="Search Riho .." name="q" title="" autofocus="">
                                <div class="spinner-border Typeahead-spinner" role="status"><span
                                        class="sr-only">Loading... </span></div><i class="close-search"
                                    data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"> </div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"> <a href="index.html"><img class="img-fluid for-light"
                                src="{{ asset('dashboard_assests') }}/images/logo/logo_dark.png"
                                alt="logo-light"><img class="img-fluid for-dark"
                                src="{{ asset('dashboard_assests') }}/images/logo/logo.png" alt="logo-dark"></a>
                    </div>
                    <div class="toggle-sidebar"> <i class="status_toggle middle sidebar-toggle"
                            data-feather="align-center"></i></div>
                </div>
                <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
                    <div> <a class="toggle-sidebar" href="#"> <i class="iconly-Category icli"> </i></a>
                        <div class="d-flex align-items-center gap-2 ">
                            <h4 class="f-w-600">Welcome {{ auth()->user()->name }}</h4><img class="mt-0"
                                src="{{ asset('dashboard_assests') }}/images/hand.gif" alt="hand-gif">
                        </div>
                    </div>
                    @if (Auth::user()->role == 'admin')
                        <div class="welcome-content d-xl-block d-none"><span class="text-truncate col-12">Here’s
                                what’s happening with your Student Management Area. </span></div>
                    @elseif(Auth::user()->role == 'admin')
                        <div class="welcome-content d-xl-block d-none"><span class="text-truncate col-12">Here’s
                                what’s happening with your Student Management Area.</span></div>
                    @else
                        <div class="welcome-content d-xl-block d-none"><span class="text-truncate col-12">Here’s
                                what’s happening with your Student Management Area.</span></div>
                    @endif
                </div>
                <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                    <ul class="nav-menus">
                        <li>
                            <div class="mode d-flex mr-2 align-items-center">
                                <h6 class="dark_mode">
                                    </h5><i class="moon ms-2" data-feather="moon"> </i>
                            </div>
                        </li>
                        <li class="profile-nav onhover-dropdown">
                            <div class="media profile-media"><img class="b-r-10"
                                    src="{{ asset('dashboard_assests') }}/images/dashboard/profile.png"
                                    alt="">
                                <div class="media-body d-xxl-block d-none box-col-none">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>{{ Auth::user()->name }}</span><i class="middle fa fa-angle-down"> </i>
                                    </div>
                                    <p class="mb-0 font-roboto">{{ auth()->user()->role }}</p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="{{ route('profile') }}"><i data-feather="user"></i><span>My Profile</span></a>
                                </li>
                                <li><a href="letter-box.html"><i data-feather="mail"></i><span>Inbox</span></a></li>
                                <li> <a href="edit-profile.html"> <i data-feather="settings"></i><span>Settings</span></a></li>

                                {{-- logout components --}}
                                    <li>
                                        <livewire:logout />
                                    </li> 
                                {{-- logout components --}}

                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details"> 
            <div class="ProfileCard-realName">name</div>
            </div> 
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" data-layout="stroke-svg">
                <div class="logo-wrapper"><a href="index.html"><img width="120" height="40" class="img-fluid"
                            src="{{ asset('dashboard_assests') }}/images/logo/logo1.jpg" alt=""></a>
                    <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                        </i></div>
                </div>
                <div class="logo-icon-wrapper"><a href="index.html"><img width="50" height="50" class="img-fluid"
                            src="{{ asset('dashboard_assests') }}/images/logo/logo1.jpg" alt=""></a>
                </div>
                <nav class="sidebar-main">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="sidebar-menu">
                        <ul class="sidebar-links" id="simple-bar">
                            <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                        src="{{ asset('dashboard_assests') }}/images/logo/logo-icon.png"
                                        alt=""></a>
                                <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                                        aria-hidden="true"></i></div>
                            </li>
                            <li class="pin-title sidebar-main-title">
                                <div>
                                    <h6>Pinned</h6>
                                </div>
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6 class="lan-1">General</h6>
                                </div>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-home">
                                        </use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#fill-home">
                                        </use>
                                    </svg><span class="lan-3">Dashboard </span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="index.html">Default</a></li>
                                    <li><a href="dashboard-02.html">Ecommerce</a></li>
                                    <li><a href="dashboard-03.html">Project</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use
                                            href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-widget">
                                        </use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#fill-widget">
                                        </use>
                                    </svg><span class="lan-6">Widgets</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="general-widget.html">General</a></li>
                                    <li><a href="chart-widget.html">Chart</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use
                                            href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-layout">
                                        </use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#fill-layout">
                                        </use>
                                    </svg><span class="lan-7">Page layout</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="box-layout.html">Boxed</a></li>
                                    <li><a href="layout-rtl.html">RTL</a></li>
                                    <li><a href="layout-dark.html">Dark Layout</a></li>
                                    <li> <a href="hide-on-scroll.html">Hide Nav Scroll</a></li>
                                </ul>
                            </li>
                            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </div>
                </nav>
            </div>
            
            {{-- Container start --}}
                @yield('content')
            {{-- Container End --}}

            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2024 © Riho theme by pixelstrap </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('dashboard_assests') }}/js/jquery.min.js"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('dashboard_assests') }}/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="{{ asset('dashboard_assests') }}/js/icons/feather-icon/feather.min.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('dashboard_assests') }}/js/scrollbar/simplebar.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('dashboard_assests') }}/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('dashboard_assests') }}/js/sidebar-menu.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/sidebar-pin.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/slick/slick.min.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/slick/slick.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/header-slick.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/apex-chart/apex-chart.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/apex-chart/stock-prices.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/apex-chart/moment.min.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/echart/esl.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/echart/config.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/echart/pie-chart/facePrint.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/echart/pie-chart/testHelper.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/echart/pie-chart/custom-transition-texture.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/chart/echart/data/symbols.js"></script>
    <!-- calendar js-->
    <script src="{{ asset('dashboard_assests') }}/js/datepicker/date-picker/datepicker.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/datepicker/date-picker/datepicker.custom.js"></script>
    <script src="{{ asset('dashboard_assests') }}/js/dashboard/dashboard_3.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('dashboard_assests') }}/js/script.js"></script>
    {{-- <script src="{{ asset('dashboard_assests') }}/js/theme-customizer/customizer.js"></script> --}}
    <script>
        let dark = document.querySelector('.dark_mode');
        let mode = localStorage.setItem("mode", "Light Mode");
        dark.innerHTML = localStorage.getItem("mode");
        // alert(dark.innerHTML)
        dark.addEventListener('click', () => {
            if (dark.innerHTML == 'Light Mode') {
                    localStorage.setItem("mode", "Dark Mode");
                    dark.innerHTML = localStorage.getItem("mode");

            } else {
                    localStorage.setItem("mode", "Light Mode")
                    dark.innerHTML = localStorage.getItem("mode");
            }
        })
    </script>
</body>

</html>

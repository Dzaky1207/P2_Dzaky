<!-- Start Header Area -->
<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            <!-- <li><i class="ti-headphone-alt"></i> +62 895-3524-58583</li>
                            <li><i class="ti-email"></i> support@gmail.com</li> -->
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-8 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            @auth
                            <li><i class="ti-user"></i>
                                <a href="{{ route('profile.edit')}}">{{ Auth::user()->name ?? '' }}</a>
                            </li>
                            <li><i class="ti-power-off"></i>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
                                        Logout
                                    </button>
                                </form>
                            </li>
                            @endauth

                            @guest
                            <li><i class="ti-user"></i>
                                <a href="#">Datta Able</a>
                            </li>
                            <li><i class="ti-power-off"></i>
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                            @endguest

                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/favicon.svg') }}" alt="Logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <form>
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li><a href="{{ route('dashboard') }}">Home</a></li>
                                            <li><a href="">About Us</a></li>
                                            <li><a href="">Contact Us</a></li>
                                            <li><a href="">Tiket Saya</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
<!-- End Header Area -->
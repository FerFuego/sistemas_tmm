<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> 
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"> 
                    <a class="logo" href="index.php">
                        <span class="hidden-xs">
                           {{--  <img src="{{ asset('/images/logo-white.png') }}" width="100px"> --}}
                        </span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    @php
                        $site = 'http://'.$_SERVER['HTTP_HOST'];
                        $crumbs = explode('/', strrev($_SERVER["REQUEST_URI"]), 2);
                        $homeurl = $site.strrev($crumbs[1]);
                        $page = strrev($crumbs[0]);
                    @endphp 
                    @if ($page != 'dashboard' && $page != 'todos')
                        <li><a href="javascript:history.back();" title="volver"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    @endif
                </ul>
                <div class="pull-right p-10-20">
                    <img src="{{ asset('/images/logo-white.png') }}" width="100px">
                </div>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
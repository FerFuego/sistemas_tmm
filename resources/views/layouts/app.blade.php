<!DOCTYPE html>  
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon.png') }}">
    <title>@yield('title','TecnicasMM')</title>
    <link href="{{ asset('css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/fonts/Simple-Line-Icons.svg">
    <link href="{{ asset('plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/css-chart/css-chart.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors/default-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-19175540-9', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>
    @if($auth == 1)
        @includeIf('assets.header')
        @includeIf('assets.left-sidebar')
        @includeIf('assets.breadcrumbs')
    @endif
    <!-- Page Content -->
    <div id="page-wrapper"  @if($auth != 1) style="height: 100vh; width: 100vw; margin: 0;"  @endif  >
        <div class="container-fluid fonts">
            @if($auth == 1)
                <div class="row bg-title">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h4 class="page-title text-uppercase">@yield('title-section','TecnicasMM')</h4> 
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12"> 
                        @yield('breadcrumbs')
                        <?php /*echo breadcrumbs(); */?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            @endif
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('flash::message')
                    @yield('content')
                    @yield('javascript')
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        @if($auth == 1)
            @includeIf('assets.footer')
        @endif
    </div>
    <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    {{--<script src="{{ asset('js/bootstrap/dist/js/tether.min.js') }}"></script>--}}
    <script src="{{ asset('js/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    {{--<script src="{{ asset('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>--}}
    <script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    {{--<script src="{{ asset('js/waves.js') }}"></script>--}}
    <script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    {{--<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>--}}
    {{--<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>--}}
    <script src="{{ asset('js/custom.min.js') }}"></script>
    {{-- <script src="{{ asset('js/dashboard1.js') }}"></script> --}}
    <script src="{{ asset('plugins/bower_components/Chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Translated
            $('.dropify').dropify({
                messages: {
                    default: 'Arrastra una imagen o adjuntá una imagen'
                    , replace: 'Arrastra una imagen o adjuntá una imagen'
                    , remove: 'Remplazar'
                    , error: 'Opps, algo salió mal'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                }
                else {
                    drDestroy.init();
                }
            })
        });

        var input = document.querySelectorAll("label.check input");
            if(input !== null) {
              [].forEach.call(input, function(el) {
                if(el.checked) {
                  el.parentNode.classList.add('c_on');
                  $(el).attr('checked', false);
                }
                el.addEventListener("click", function(event) {
                  event.preventDefault();
                  el.parentNode.classList.toggle('c_on');
                  $(el).attr('checked', true);
                }, false);
              });
            }
    </script>
    <!-- Style Switcher -->
    <script src="{{ asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
    <!-- LightBox 2 -->
    <script src="{{ asset('js/lightbox.js') }}"></script>
</body>

</html>
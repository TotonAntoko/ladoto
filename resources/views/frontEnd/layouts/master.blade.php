<!DOCTYPE HTML>
<html>

<head>
    <title>Spike shoes Website Template | Home :: w3layouts</title>
    <link href="{{asset('frontEnd/css/style.css')}}" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    </script>
    <!----webfonts---->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!----//webfonts---->
    <!----start-alert-scroller---->
    <script src="{{asset('frontEnd/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontEnd/js/jquery.easy-ticker.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#demo').hide();
            $('.vticker').easyTicker();
        });
    </script>
    <!----start-alert-scroller---->
    <!-- start menu -->
    <link href="{{asset('frontEnd/css/megamenu.css')}}" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="{{asset('frontEnd/js/megamenu.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".megamenu").megamenu();
        });
    </script>
    <script src="{{asset('frontEnd/js/menu_jquery.js')}}"></script>
    <!-- //End menu -->
    <!---slider---->
    <link rel="stylesheet" href="{{asset('frontEnd/css/slippry.css')}}">
    <script src="{{asset('frontEnd/js/jquery-ui.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontEnd/js/scripts-f0e4e0c2.js')}}" type="text/javascript"></script>
    <script>
        jQuery('#jquery-demo').slippry({
            // general elements & wrapper
            slippryWrapper: '<div class="sy-box jquery-demo" />', // wrapper to wrap everything, including pager
            // options
            adaptiveHeight: false, // height of the sliders adapts to current slide
            useCSS: false, // true, false -> fallback to js if no browser support
            autoHover: false,
            transition: 'fade'
        });
    </script>
    <!----start-pricerage-seletion---->
    <script type="text/javascript" src="{{asset('frontEnd/js/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('frontEnd/css/jquery-ui.css')}}">
    <script type='text/javascript'>
        //<![CDATA[ 
        $(window).load(function () {
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 500,
                values: [100, 400],
                slide: function (event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider(
                "values", 1));

        }); //]]>  
    </script>
    <!----//End-pricerage-seletion---->
    <!---move-top-top---->
    <script type="text/javascript" src="{{asset('frontEnd/js/move-top.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontEnd/js/easing.js')}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1200);
            });
        });
    </script>
    <!---//move-top-top---->

    {{-- FOR DETAILS PRODUCT --}}
    <!-- Owl Carousel Assets -->
    <link href="{{asset('frontEnd/css/owl.carousel.css')}}" rel="stylesheet">
    <script src="{{asset('frontEnd/js/jquery-1.9.1.min.js')}}"></script> 
    <!-- Owl Carousel Assets -->
    <!-- Prettify -->
    <script src="{{asset('frontEnd/js/owl.carousel.js')}}"></script>
    <script>
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({
        items : 3,
        lazyLoad : true,
        autoPlay : true,
        navigation : true,
        navigationText : ["",""],
        rewindNav : false,
        scrollPerPage : false,
        pagination : false,
        paginationNumbers: false,
        });

    });
    </script>
    <!-- //Owl Carousel Assets -->
</head>

<body>
    {{-- @section('sidebar')
    This is the master sidebar.
    @show --}}
    @include('frontEnd.layouts.header')
    {{-- <div class="container"> --}}
        @yield('content')
    {{-- </div> --}}
    @include('frontEnd.layouts.footer')
</body>

</html>
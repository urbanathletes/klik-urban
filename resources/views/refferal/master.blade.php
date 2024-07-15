<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Refferal Form Fitnessworks" />
    <title>Fitnessworks - Refferal</title>
    <link rel="icon" href="{{ URL::asset('../assets/refferal/img/favicon.ico'); }}">
    <link rel="stylesheet" href="{{ URL::asset('../assets/refferal/css/bootstrap/bootstrap.css'); }}" />
   <link rel="stylesheet" href="{{ URL::asset('../assets/refferal/fonts/material-icon/css/material-design-iconic-font.min.css'); }}">
    <link rel="stylesheet" href="{{ URL::asset('../assets/refferal/font-awesome/all.css'); }}">
    <script src="{{ URL::asset('../assets/refferal/vendor/jquery/jquery.min.js'); }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* 
---------------------------------------------
Pre Loader
--------------------------------------------- 
*/

        .js-preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            display: -webkit-box;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            z-index: 9999;
            -webkit-transition: opacity 0.25s ease;
            transition: opacity 0.25s ease;
        }

        .js-preloader.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        @-webkit-keyframes dot {
            50% {
                -webkit-transform: translateX(96px);
                transform: translateX(96px);
            }
        }

        @keyframes dot {
            50% {
                -webkit-transform: translateX(96px);
                transform: translateX(96px);
            }
        }

        @-webkit-keyframes dots {
            50% {
                -webkit-transform: translateX(-31px);
                transform: translateX(-31px);
            }
        }

        @keyframes dots {
            50% {
                -webkit-transform: translateX(-31px);
                transform: translateX(-31px);
            }
        }

        .preloader-inner {
            position: relative;
            width: 142px;
            height: 40px;
            background: #fff;
        }

        .preloader-inner .dot {
            position: absolute;
            width: 16px;
            height: 16px;
            top: 12px;
            left: 15px;
            background: #FECC09;
            border-radius: 50%;
            -webkit-transform: translateX(0);
            transform: translateX(0);
            -webkit-animation: dot 2.8s infinite;
            animation: dot 2.8s infinite;
        }

        .preloader-inner .dots {
            -webkit-transform: translateX(0);
            transform: translateX(0);
            margin-top: 12px;
            margin-left: 31px;
            -webkit-animation: dots 2.8s infinite;
            animation: dots 2.8s infinite;
        }

        .preloader-inner .dots span {
            display: block;
            float: left;
            width: 16px;
            height: 16px;
            margin-left: 16px;
            background: #1a133f;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <div class="main">
        @yield('content')
    </div>

    <script src="{{ URL::asset('../assets/refferal/js/bootstrap/bootstrap.js'); }}"></script>
    <script src="{{ URL::asset('../assets/refferal/vendor/jquery-validation/dist/jquery.validate.min.js'); }}"></script>
    <script src="{{ URL::asset('../assets/refferal/vendor/jquery-validation/dist/additional-methods.min.js'); }}"></script>
    <script src="{{ URL::asset('../assets/refferal/vendor/jquery-steps/jquery.steps.min.js'); }}"></script>
    <script src="{{ URL::asset('../assets/refferal/js/main.js'); }}"></script>
    <script src="{{ URL::asset('../assets/refferal/font-awesome/all.js'); }}"></script>
    <script>
        // Page loading animation
        $(window).on('load', function() {
            $('#js-preloader').addClass('loaded');
        });
    </script>
</body>

</html>
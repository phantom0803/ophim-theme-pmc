@extends('themes::layout')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();
@endphp

@push('header')
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500&amp;display=swap' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/pmc/bootstrap/css/bootstrap.min.css') }}" as="style" rel="preload" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/pmc/css/can-toggle.css?v=1.0') }}" as="style" rel="preload">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/pmc/css/font-awesome.min.css') }}" rel="preload" as="font" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/pmc/css/mainpmchill.css') }}" as="style" rel="preload" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/pmc/css/responsive.css') }}" as="style" rel="preload" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/pmc/css/page_index.css') }}" as="style" rel="preload" />

    <script type="text/javascript" src="{{ asset('/themes/pmc/js/jquery-1.11.1.min.js') }}"></script>
    <script defer type="text/javascript" src="{{ asset('/themes/pmc/bootstrap/js/bootstrap.min.js') }}"></script>
    <script defer type="text/javascript" src="{{ asset('/themes/pmc/js/lazyz.min.js') }}"></script>

    <link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
    <link href='https://fonts.gstatic.com/' crossorigin rel='preconnect' />
@endpush

@section('body')
    @include('themes::themepmc.inc.header')
    <div id="main-content">
        @if (get_theme_option('ads_header'))
            {!! get_theme_option('ads_header') !!}
        @endif
        <div id="content">
            @yield('content')
        </div>
    </div>
    {!! get_theme_option('tag_box') !!}
@endsection

@section('footer')
    {!! get_theme_option('footer') !!}

    @if (get_theme_option('ads_catfish'))
        {!! get_theme_option('ads_catfish') !!}
    @endif

    <script>
        var $menu = $("#menu-mobile");
        var $over_lay = $('#overlay_menu');
        var hw = $(window).height();

        function set_height_menu() {}

        function open_menu() {
            $('body').addClass('menu-active');
            $menu.addClass('expanded');
            set_height_menu();
            $(".btn-humber").addClass('active');
        }

        function close_menu() {
            $('body').removeClass('menu-active');
            $menu.removeClass('expanded');
            var w_scroll_top = $(window).scrollTop();
            if (w_scroll_top >= 50) {
                pos_top_menu = 0;
            } else {
                pos_top_menu = w_scroll_top;
            }
            set_height_menu();
            $(".btn-humber").removeClass('active');
        }
        $(document).ready(function() {
            $(".btn-humber").click(function() {
                if ($menu.hasClass('expanded')) {
                    close_menu();
                } else {
                    open_menu();
                }
            });
            $(window).scroll(function() {
                set_height_menu();
            });
            $(".parent-menu").click(function(e) {
                e.preventDefault();
                $this = $(this);
                $arrow = $this.find('.fa');
                if ($arrow.length && event.target.className != 'sub-menu-link') {
                    if ($arrow.hasClass('fa-angle-down')) {
                        $arrow.removeClass('fa-angle-down').addClass('fa-angle-up');
                    } else {
                        $arrow.addClass('fa-angle-down').removeClass('fa-angle-up');
                    }
                    $this.find('.sub-menu').toggle();
                    return false;
                } else {
                    var href = event.target.href;
                    window.location.href = href;
                }
            });
        });
    </script>

    {!! setting('site_scripts_google_analytics') !!}
@endsection

@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<div id="header">
    <div class="container">
        <div id="logo" style="margin:0;">
            <a href="/" title="{{ $title }}">
                @if ($logo)
                    {!! $logo !!}
                @else
                    {!! $brand !!}
                @endif
            </a>
        </div>
        <ul id="main-menu">
            @foreach ($menu as $item)
                @if (count($item['children']))
                    <li> <a title="{{ $item['name'] }}" href="{{ $item['link'] }}" rel="nofollow">{{ $item['name'] }}</a>
                        <ul class="sub-menu span-6">
                            @foreach ($item['children'] as $children)
                                <li><a class="sub-menu-link" href="{{ $children['link'] }}">{{ $children['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li> <a title="{{ $item['name'] }}" href="{{ $item['link'] }}">{{ $item['name'] }}</a> </li>
                @endif
            @endforeach
        </ul>
        <form method="GET" id="form-search" class="form-search" action="/">
            <input placeholder="Tìm tên phim..." value="{{ request('search') }}" type="text" name="search" />
            <i id="searchsubmit" class="fa fa-search" value="" type="submit"></i>
        </form>
    </div>
</div>
<div id="mobile-header">
    <div class="btn-humber"></div>
    <a class="logo" href="" title="Phim Mới">
        @if ($logo)
            {!! $logo !!}
        @else
            {!! $brand !!}
        @endif
    </a>
    <i class="fa fa-search btn-search" onclick="$('.mobile-search-bar').removeClass('hide');$('#keyword').focus();"></i>
    <div class="mobile-search-bar hide">
        <form id="mobile-form_search" action="">
            <input id="keyword" value="{{ request('search') }}" type="text" name="search" placeholder="Tìm kiếm...">
        </form>
        <i class="fa fa-times close-button" onclick="$('.mobile-search-bar').addClass('hide')"></i>
    </div>
</div>
<div id="bswrapper_inhead"></div>
<div id="menu-mobile" class="">
    <ul>
        @foreach ($menu as $item)
            @if (count($item['children']))
                <li class="parent-menu"> <a title="{{ $item['name'] }}" id="menu" href="{{ $item['link'] }}" rel="nofollow">{{ $item['name'] }} <i class="fa fa-angle-down"></i></a>
                <ul class="sub-menu span-6" style="display: none;">
                    @foreach ($item['children'] as $children)
                        <li>
                            <a class="sub-menu-link" href="{{ $children['link'] }}">{{ $children['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>

            @else
                <li> <a title="{{ $item['name'] }}" href="{{ $item['link'] }}">{{ $item['name'] }}</a> </li>
            @endif
        @endforeach
    </ul>
</div>
<div id="chilladv" class="container">
    <div id="headerpcads"></div>
    <div id="headermbads"></div>
</div>
<div class="container">
    <div id="topnc"></div>
</div>

@extends('themes::themepmc.layout')
@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp

@section('content')
    <div class="container" id="detail-page">
        @if ($currentMovie->notify && $currentMovie->notify != '')
            <div class="block-note">
                Thông báo: <span class="text-danger">{{ strip_tags($currentMovie->notify) }}</span>
            </div>
        @endif
        @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
            <div class="block-note">
                Lịch chiếu: <span class="text-info">{!! $currentMovie->showtimes !!}</span>
            </div>
        @endif
        <div class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" itemprop="url"
                    href="/" title="Xem phim"><span itemprop="name"><i class="fa fa-home"></i> Xem
                        phim <i class="fa fa-angle-right"></i></span></a>
                <meta itemprop="position" content="1" />
            </li>
            @foreach ($currentMovie->categories as $category)
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="{{ $category->getUrl() }}" title="{{ $category->name }}">
                        <span itemprop="name">
                            {{ $category->name }} <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
            @endforeach
            <li>{{ $currentMovie->name }}</li>
        </div>
        <div class="clear"></div>
        <div class="film-info" itemscope itemtype="https://schema.org/Movie">
            <div class="image"
                style="background: url({{ $currentMovie->getPosterUrl() }}) no-repeat center;background-size: cover;">
                <img class="avatar" itemprop="image" alt="{{ $currentMovie->name }}" src="{{ $currentMovie->getThumbUrl() }}" />
                @if ($watch_url)
                    <a href="{{ $watch_url }}" class="icon-play"></a>
                @endif
                <div class="text">
                    <h1 itemprop="name">{{ $currentMovie->name }}</h1>
                    <h2>{{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})</h2>
                    <ul class="list-button">
                        @if ($currentMovie->trailer_url)
                            <li> <a class="btn btn-download btn-info" onclick="trailer();"
                                    title="Trailer {{ $currentMovie->name }}-{{ $currentMovie->origin_name }}">
                                    <i class="fa fa-youtube-play"></i> Trailer
                                </a>
                            </li>
                        @endif
                        @if ($watch_url)
                            <li> <a class="btn-see btn btn-danger"
                                    title="Xem phim {{ $currentMovie->name }} {{ $currentMovie->origin_name }}"
                                    href="{{ $watch_url }}">
                                    <i class="fa fa-play-circle-o"></i> Xem phim </a> </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="text">
                <div class="social">
                    <div class="fb-send" data-href="{{ $currentMovie->getUrl() }}"></div>
                    <div class="fb-like" data-href="{{ $currentMovie->getUrl() }}" data-layout="button_count"
                        data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
                    <div class="box-rating">
                        <input id="hint_current" type="hidden" value="">
                        <input id="score_current" type="hidden"
                            value="{{$currentMovie->getRatingStar()}}">
                        <div id="star" data-score="{{$currentMovie->getRatingStar()}}"
                            style="cursor: pointer; float: left; width: 200px;">
                        </div>
                        <span id="hint"></span>
                        <div id="div_average" style="float:left; line-height:20px; margin:0 5px; ">(<span class="average"
                                id="average">{{$currentMovie->getRatingStar()}}</span> đ/<span
                                id="rate_count"> /
                                {{$currentMovie->getRatingCount()}}</span> lượt)
                        </div>
                        <img class="hidden" itemprop="thumbnailUrl"
                            src="{{ $currentMovie->getPosterUrl() }}"
                            alt="{{ $currentMovie->name }} {{ $currentMovie->origin_name }}"> <img class="hidden"
                            itemprop="image" src="{{ $currentMovie->getPosterUrl() }}"
                            alt="{{ $currentMovie->name }} {{ $currentMovie->origin_name }}">
                        <span class="hidden" itemprop="aggregateRating" itemscope
                            itemtype="https://schema.org/AggregateRating"> <span itemprop="ratingValue">5</span>
                            <meta itemprop="ratingcount" content="{{$currentMovie->getRatingCount()}}">
                            <meta itemprop="bestRating" content="10" />
                            <meta itemprop="worstRating" content="1" />
                        </span>
                    </div>
                </div>
                <ul class="entry-meta block-film">
                    <li> <label>Đang phát: </label>
                        <span>
                            <font color="red">{{ $currentMovie->episode_current }}</font>
                        </span>
                    </li>
                    <li> <label>Tổng số tập: </label>
                        <span>
                            <font color="yellow">{{ $currentMovie->episode_total ?? 'N/A' }}</font>
                        </span>
                    </li>
                    <li> <label>Năm Phát Hành: </label> {{ $currentMovie->publish_year }}
                    </li>
                    <li> <label>Quốc gia: </label>
                        {!! $currentMovie->regions->map(function ($region) {
                                return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                            })->implode(', ') !!}
                    </li>
                    <li> <label>Thể loại: </label>
                        {!! $currentMovie->categories->map(function ($category) {
                                return '<a href="' . $category->getUrl() . '" title="' . $category->name . '">' . $category->name . '</a>';
                            })->implode(', ') !!}
                    </li>
                    <li> <label>Đạo diễn: </label>
                        <span itemprop="director" itemscope itemtype="http://schema.org/Person">
                            {!! $currentMovie->directors->map(function ($director) {
                                    return '<a href="' .
                                        $director->getUrl() .
                                        '" title="' .
                                        $director->name .
                                        '"><span itemprop="name">' .
                                        $director->name .
                                        '</span></a>';
                                })->implode(', ') !!}
                        </span>
                    </li>
                    <li>
                    <li> <label>Chất lượng: </label><span
                            class="imdb">{{ $currentMovie->quality }}-{{ $currentMovie->language }}</span></li>
                    <li><label>Thời lượng: </label> {{ $currentMovie->episode_time }}</li>
                    <li> <label>Diễn viên: </label>
                        {!! $currentMovie->actors->map(function ($actor) {
                                return '<a href="' . $actor->getUrl() . '" title="' . $actor->name . '">' . $actor->name . '</a>';
                            })->implode(', ') !!}
                    </li>
                </ul>
                <div class="clear"></div>
                <div class="film-content block-film" id="film-content-wrapper">
                    <h3 class="heading">Nội dung phim {{ $currentMovie->name }}</h3>
                    <div id="film-content">
                        @if ($currentMovie->content)
                            {!! $currentMovie->content !!}
                        @else
                            <p>Hãy xem phim để cảm nhận...</p>
                        @endif
                    </div>
                </div>
                @if ($currentMovie->trailer_url)
                    <div class="block-film" style="display: none;" id="trailer">
                        <p class="heading">Trailer phim {{ $currentMovie->name }} {{ $currentMovie->origin_name }}:</p>
                        <script src="/themes/pmc/js/jwplayer.js"></script>
                        <script>
                            jwplayer.key = "v/ZlqxWwz7+Q/6HLTJptCVOXdTqOThKXmx1TTA==";
                        </script>
                        <div id="mediaplayer"></div>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                var playerInstance = jwplayer("mediaplayer");

                                function load_biplayer() {
                                    playerInstance.setup({
                                        file: "{{ $currentMovie->trailer_url }}",
                                        image: "{{ $currentMovie->getPosterUrl() }}",
                                        skin: {
                                            name: "seven",
                                            background: "transparent",
                                        },
                                        width: "100%",
                                        height: "100%",
                                        aspectratio: "16:9",
                                        autostart: false,
                                    });
                                }
                                load_biplayer();
                            });
                        </script>
                    </div>
                @endif
                <div class="block-film" id="tags">
                    <p class="heading">Tags</p>
                    <div class="tags-list">
                        @foreach ($currentMovie->tags as $tag)
                            <li class="tag">
                                <h3><a href="{{ $tag->getUrl() }}" title="{{ $tag->name }}">{{ $tag->name }}</a>
                                </h3>
                            </li>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="comment">
                <div class="fb-comments" data-href="{{ $currentMovie->getUrl() }}" data-colorscheme="dark"
                    data-width="980" data-order-by="reverse_time"></div>
            </div>
            <div class="block film-related">
                <div class="heading">
                    <p class="caption">Có thể bạn cũng muốn xem</p>
                </div>
                <ul class="list-film horizontal top-slide" id="list-film-realted">
                    @foreach ($movie_related as $movie)
                        <li class="item ">
                            <span class="label"></span> <span class="label-quality">{{ $movie->publish_year }}</span>
                            <a title="{{ $movie->name }} - {{ $movie->origin_name }}" href="{{ $movie->getUrl() }}">
                                <img alt="{{ $movie->name }}" class="lazyload"
                                    data-src="{{ $movie->getPosterUrl() }}" />
                                <p>{{ $movie->name }}</p> <i class="icon-play"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js">
    </script>

    <script>
        var rated = false;
        var URL_POST_RATING = '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}';
    </script>

    <script defer type="text/javascript" src="{{ asset('/themes/pmc/libs/jquery-raty/jquery.raty.js') }}"></script>
    <script defer type="text/javascript" src="{{ asset('/themes/pmc/js/public.phim.js') }}"></script>

    <script type="text/javascript">
        function trailer() {
            $('#trailer').css("display", "block");
            $('#trailer').fadeIn('slow');
            $('html, body').animate({
                scrollTop: $("#trailer").offset().top
            }, 500);
        }
    </script>
    <script src="/themes/pmc/js/owl.carousel.min.js"></script>
    <script>
        $(function() {
            $("#list-film-realted").owlCarousel({
                items: 5,
                itemsTablet: [700, 3],
                itemsMobile: [479, 2],
                scrollPerPage: true,
                navigation: true,
                slideSpeed: 800,
                paginationSpeed: 400,
                stopOnHover: true,
                pagination: false,
                autoPlay: 8000,
                lazyLoad: true,
                navigationText: ['<i class="fa fa fa-caret-left"></i>',
                    '<i class="fa fa fa-caret-right"></i>'
                ],
            });
        })
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush

@extends('themes::themepmc.layout')

@section('content')
    <div class="container" id="page-player">
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
        <div class="box-player" id="box-player">
            <div id="player">
                <div id="player-area">
                </div>
            </div>
            <div class="film-note" style="margin-bottom:20px;border: 1px solid #B8B612;padding: 5px;">Phim Xem
                tốt nhất trên trình duyệt Safari,FireFox hoặc Chrome. Đừng tiếc 1 comment bên dưới để đánh giá
                phim hoặc báo lỗi. Đổi server nếu lỗi,lag</div>
            <div class="options">
                <ul class="tool">
                    <li class="power-lamp">
                        <span class="text-lamp">Tắt đèn</span>
                        <em class="radial-center">
                            <i class="fa fa-power-off"></i>
                        </em>
                    </li>
                </ul>
            </div>
        </div>
        <div id="pm-server">
            <center>
                <ul class="server-list">
                    <li class="backup-server"> <span class="server-title">Đổi Sever</span>
                        <ul class="list-episode">
                            <li class="episode">
                                @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                    <a data-id="{{ $server->id }}" data-link="{{ $server->link }}"
                                        data-type="{{ $server->type }}" onclick="chooseStreamingServer(this)"
                                        class="streaming-server btn-link-backup btn-episode black episode-link">VIP
                                        #{{ $loop->index + 1 }}</a>
                                @endforeach
                            </li>
                        </ul>
                    </li>
                </ul>
            </center>
        </div>
        <div class="list-server" id="list-server">
            @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                <div class="server-group clearfix">
                    <span><i class="fa fa-database"></i> Danh sách tập {{$server}}</span>
                    <ul class="episodes">
                        @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                            <li><a href="{{ $item->sortByDesc('type')->first()->getUrl() }}" title="Xem phim {{$currentMovie->name}} {{ (strpos(strtolower($name), 'tập')) ? $name : 'Tập ' . $name }}" class="@if ($item->contains($episode)) active @endif">{{ (strpos(strtolower($name), 'tập')) ? $name : 'Tập ' . $name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div style="clear:both;"></div>
        <div class="box-rating">
            <input id="hint_current" type="hidden" value="">
            <input id="score_current" type="hidden" value="{{$currentMovie->getRatingStar()}}">
            <p>Đánh giá phim <span class="text">({{$currentMovie->getRatingStar()}}đ / {{$currentMovie->getRatingCount()}} lượt)</span></p>
            <div id="star" data-score="{{$currentMovie->getRatingStar()}}"
                style="cursor: pointer; float: left; width: 200px;">
            </div>
            <span id="hint"></span>
            <img class="hidden" itemprop="thumbnailUrl" src="{{ $currentMovie->getPosterUrl() }}"
                alt="{{ $currentMovie->name }} {{ $currentMovie->origin_name }}"> <img class="hidden" itemprop="image"
                src="{{ $currentMovie->getPosterUrl() }}"
                alt="{{ $currentMovie->name }} {{ $currentMovie->origin_name }}">
            <span class="hidden" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"> <span
                    itemprop="ratingValue">5</span>
                <meta itemprop="ratingcount" content="{{$currentMovie->getRatingCount()}}">
                <meta itemprop="bestRating" content="10" />
                <meta itemprop="worstRating" content="1" />
            </span>
        </div>
        <div class="social">
            <div class="fb-like" style="margin:auto;width: 100%;" data-href="{{ $currentMovie->getUrl() }}"
                data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"
                data-colorscheme="light"></div>
            <div class="fb-save" data-uri="{{ $currentMovie->getUrl() }}"></div>
        </div>
        <div class="clear"></div>
        <div class="film-info">
            <h1 itemprop="name"><a title="Xem phim {{$currentMovie->name}}" href="">{{$currentMovie->name}}</a> -
                Tập {{$episode->name}}</h1>
            <h2 style="margin: 0px;font-size: 15px;"> <a title="{{$currentMovie->origin_name}}" href="{{$currentMovie->getUrl()}}"> {{$currentMovie->origin_name}} </a></h2>
            <img class="hidden" itemprop="thumbnailUrl"
                src="{{ $currentMovie->getPosterUrl() }}"
                alt="{{ $currentMovie->name }}-{{ $currentMovie->origin_name }}"> <img class="hidden" itemprop="image"
                src="{{ $currentMovie->getPosterUrl() }}"
                alt="{{ $currentMovie->name }}-{{ $currentMovie->origin_name }}">
            <p
                style="padding: 4px 4px;margin: 5px 0 20px 0;line-height: 26px;font-size: 12px;color: #BBB;background: #322b2b;">
                {!! mb_substr(strip_tags(trim($currentMovie->content)), 0, 260, 'UTF-8') !!}...
                [<a href="{{ $currentMovie->getUrl() }}"
                    title="{{ $currentMovie->name }} - {{ $currentMovie->origin_name }}">Xem thêm</a>]</p>

            <div class="breadcrumb" style="float: none;" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item"
                        itemprop="url" href="/" title="Xem phim"><span itemprop="name"><i class="fa fa-home"></i>
                            Xem
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
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a
                        href="{{ $currentMovie->getUrl() }}" itemprop="item"><span
                            itemprop="name">{{ $currentMovie->name }} <i class="fa fa-angle-right"></i></span></a>
                    <meta itemprop="position" content="3" />
                </li>
                <li>Tập {{ $episode->name }}</li>
            </div>
            <div class="comment" itemprop="comment">
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
            </div>
        </div>
        <div class="clear"></div>
    </div>
@endsection

@push('scripts')

<script src="/themes/pmc/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/pmc/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $('#player-area').offset().top
            }, 'slow');
        });
    </script>

    <script>
        var episode_id = {{$episode->id}};
        const wrapper = document.getElementById('player-area');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('active');
            })
            el.classList.add('active');

            link.replace('http://', 'https://');
            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/legend/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{$episode->id}}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js">
    </script>

    <script>
        var rated = false;
        var URL_POST_RATING = '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}';
    </script>

    <script defer type="text/javascript" src="{{ asset('/themes/pmc/libs/jquery-raty/jquery.raty.js') }}"></script>
    <script defer type="text/javascript" src="{{ asset('/themes/pmc/js/public.phim.js') }}"></script>

    <script src="/themes/pmc/js/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".power-lamp").click(function() {
                var $overlay = '<div id="background_lamp"></div>';
                if ($(this).hasClass('off')) {
                    $(this).removeClass('off');
                    $(".text-lamp").text('Tắt đèn');
                    $("#background_lamp").remove();
                } else {
                    $(this).addClass('off');
                    $(".text-lamp").text('Bật đèn');
                    $('body').append($overlay);
                }
            });
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

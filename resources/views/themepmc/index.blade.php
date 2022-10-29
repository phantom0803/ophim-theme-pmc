@extends('themes::themepmc.layout')

@php
    use Ophim\Core\Models\Movie;

    $recommendations = Cache::remember('site.movies.recommendations', setting('site_cache_ttl', 5 * 60), function () {
        return Movie::where('is_recommended', true)
            ->limit(get_theme_option('recommendations_limit', 10))
            ->orderBy('updated_at', 'desc')
            ->get();
    });

    $data = Cache::remember('site.movies.latest', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('latest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $link, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 12, '', 'section_poster_1']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'link' => $link,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp

@section('content')
    <div class="container">
        @include('themes::themepmc.inc.slider_recommended')

        @foreach ($data as $item)
            @include('themes::themepmc.inc.show_template.' . $item['template'])
        @endforeach
    </div>
@endsection

@push('scripts')
    <script src="/themes/pmc/js/owl.carousel.min.js"></script>
    <script>
        $("#film-hot").owlCarousel({
            items: 5,
            itemsTablet: [700, 3],
            itemsMobile: [479, 2],
            scrollPerPage: true,
            lazyLoad: true,
            navigation: true,
            slideSpeed: 800,
            paginationSpeed: 400,
            stopOnHover: true,
            pagination: false,
            autoPlay: 8000,
            navigationText: ['<i class="fa fa fa-caret-left"></i>', '<i class="fa fa fa-caret-right"></i>'],
        });

        function calc_height_item() {
            var first_height_item = $(".item.large").height();
            console.log(first_height_item);
            if (first_height_item > 0) {
                var height_small_item = (first_height_item - 10) / 2;
                $('.list-film .small a').each(function(i, obj) {
                    $(this).height(height_small_item + 'px');
                });
                $(".list-film .large a").each(function() {
                    $(this).height(first_height_item + 'px');
                })
            }
        }

        function calc_height_item_hot() {
            $("#film-hot .item").each(function() {
                var $this = $(this);
                var $a = $this.find('a');
                var width = $a.width();
                $a.height(width * 0.5625 + 'px');
            });
        }
        $(window).load(function() {});
        $(window).resize(function() {});
        $.fn.imagesLoaded = function() {
            var $imgs = this.find('img[src!=""]');
            if (!$imgs.length) {
                return $.Deferred().resolve().promise();
            }
            var dfds = [];
            $imgs.each(function() {
                var dfd = $.Deferred();
                dfds.push(dfd);
                var img = new Image();
                img.onload = function() {
                    dfd.resolve();
                };
                img.onerror = function() {
                    dfd.resolve();
                };
                img.src = this.src;
            });
            return $.when.apply($, dfds);
        };
    </script>
@endpush

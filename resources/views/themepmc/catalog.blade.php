@extends('themes::themepmc.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')
            ->distinct()
            ->pluck('publish_year')
            ->sortDesc();
    });
@endphp

@section('content')
    <div class="container filter-page">
        <div class="block">
            @include('themes::themepmc.inc.catalog_filter')
            <div class="text"
                style="margin: 0 0 10px 0;overflow: hidden;padding: 5px 10px;list-style: none;background-color: #302e2e;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;">
                <div class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                    <li itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" itemprop="url" href="/" title="Trang Chủ">
                            <span itemprop="name">
                                <i class="fa fa-home"></i> Phim Mới <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                        <meta itemprop="position" content="1" />
                    </li>
                    <li>{{ $section_name ?? 'Danh Sách Phim' }}</li>
                </div>
            </div>

            <div class="clear"></div>

            <div id="binlist">
                <ul class="list-film horizontal">
                    @if (count($data))
                        @foreach ($data as $movie)
                            <li class="item small">
                                <span class="label">
                                    <div class="status">{{ $movie->episode_current }} {{ $movie->quality }}
                                        {{ $movie->language }}</div>
                                </span>
                                <a title="{{ $movie->name }} - {{ $movie->origin_name }}" href="{{ $movie->getUrl() }}"
                                    style="height: 133.875px;">
                                    <img alt="{{ $movie->name }} - {{ $movie->origin_name }}"
                                        src="{{ $movie->getPosterUrl() }}">
                                    <h3>{{ $movie->name }}</h3> <i class="icon-play"></i>
                                </a>
                            </li>
                        @endforeach
                    @else
                        <p>Không có phim nào cho mục này...</p>
                    @endif

                </ul>
                <div class="clear"></div>
                <div class="pagination">
                    {{ $data->appends(request()->all())->links('themes::themepmc.inc.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

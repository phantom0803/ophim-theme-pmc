<div class="block">
    <div class="heading">
        <a href="{{ $item['link'] ?? '/' }}">
            <h2 class="caption">{{ $item['label'] }}</h2>
        </a>
        @if ($item['link'])
            <a class="see-more" href="{{ $item['link'] }}">Xem tất cả<i class="fa fa fa-caret-right"></i></a>
        @endif
    </div>
    <ul class="list-film horizontal">
        @foreach ($item['data'] as $movie)
            <li class="item small">
                <span class="label"></span>
                <a title="{{ $movie->name }} - {{ $movie->origin_name }}" href="{{ $movie->getUrl() }}">
                    <img width="238px" height="134px" class="img-2 lazyload" alt="{{ $movie->name }} - {{ $movie->origin_name }}" data-src="{{ $movie->getPosterUrl() }}" src="{{ $movie->getPosterUrl() }}" />
                    <p>{{ $movie->name }}</p> <i class="icon-play"></i>
                </a>
            </li>
        @endforeach
    </ul>
</div>

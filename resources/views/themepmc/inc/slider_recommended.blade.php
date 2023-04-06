<div class="block top-slide">
    <div class="heading">
        <h2 class="caption" title="Xem Phim">Phim Đề Cử</h2>
    </div>
    <ul id="film-hot" class="list-film">
        @foreach ($recommendations as $movie)
            <li class="item">
                <span class="label">
                    <span class="film-format">{{$movie->episode_current}} | {{$movie->language}}</span>
                </span>
                <a title="{{$movie->name}}" href="{{$movie->getUrl()}}">
                    <img alt="{{$movie->name}}" class="lazyload" data-src="{{$movie->getPosterUrl()}}" src="{{$movie->getUrl()}}" />
                    <p>{{$movie->name}}</p> <i class="icon-play"></i>
                </a>
            </li>
        @endforeach
    </ul>
</div>

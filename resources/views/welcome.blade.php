@extends('layouts.app')

@section('content')
    <div class="content">
        <div id="departments">
            <ul class="nav navbar-nav">
            @foreach($departments as $department)
                <li><a href="{{url('department/' . $department->id)}}">{{$department->name}}</a></li>
            @endforeach
            </ul>
        </div>

        <div id="latestNews">
            <h4>Последние новости:</h4>
            <div id="latestNewsRow">
                @foreach($latestNews as $news)
                    <div class="oneLatestNews" data-id="{{ $news->id }}">
                        <h5 class="latestNewsTitle">{{ $news->news_title }}</h5>
                        <p class="latestNewsDate">{{ \Carbon\Carbon::parse($news->date)->format('d.m.Y') }}</p>
                        <div class="latestNewsImage">
                            <img src="{{ asset('storage/' . $news->news_image) }}" alt='News image'>
                        </div>
                        <p class="latestNewsDescription">{{ $news->news_description }}</p>
                        <a href="{{ url('news/read/' . $news->id) }}" class="btn btn-secondary newsButton">Подробнее</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
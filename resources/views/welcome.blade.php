@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title m-b-md">
            eHospital
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
@extends('layouts.app')

@section('content')
    <div id="newsContent">
        <h3>{{$news->news_title}}</h3>
        <p>{{\Carbon\Carbon::parse($news->date)->format('d.m.Y')}}</p>
        <div class="newsContentImage">
            <img src="{{ asset('storage/' . $news->news_image) }}" alt='News image'>
        </div>
        <h6>{{$news->news_description}}</h6>
        <p>{{$news->news_text}}</p>
    </div>
@endsection
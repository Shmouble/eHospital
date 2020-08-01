@extends('layouts.app')

@section('content')

    @role('root.manager')
    <div class="stuff">
        <a href="#" id="addNews" data-toggle="modal" data-target="#addNewsModal">
            <h4>Add News</h4>
        </a>
    </div>
    @endrole

    <div id="newsHolder">
        @foreach($allNews as $news)
            <div class="oneNews" data-id="{{ $news->id }}">
                    <div class="newsBody">
                        <h4 class="newsTitle">{{ $news->news_title }}</h4>
                        <p class="newsDate">{{ \Carbon\Carbon::parse($news->date)->format('d.m.Y') }}</p>
                        <p class="newsDescription">{{ $news->news_description }}</p>
                        <div class="newsImage">
                            <img src="{{ asset('storage/' . $news->news_image) }}" alt='News image'>
                        </div>
                        <p class="newsText">{{ Str::limit($news->news_text, 300)  }}</p>
                        <a href="{{ url('news/read/' . $news->id) }}" class="btn btn-secondary newsButton">Подробнее</a>
                    </div>
            </div>
        @endforeach
    </div>


    <div class="modal fade" id="addNewsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" align="center"><b>Добавить новость</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addNewsForm">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="news_title"> Заголовок: </label>
                                <input type="text" class="form-control" name="news_title" id="news_title" maxlength="80" required>
                            </div>
                            <div class="form-group">
                                <label for="news_title"> Описание: </label>
                                <input type="text" class="form-control" name="news_description" id="news_description" maxlength="80" required>
                            </div>
                            <div class="form-group">
                                <label for="news_text"> Текст: </label>
                                <textarea rows="10" type="text" class="form-control textfield" name="news_text" id="news_text" required>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="news_image"> Картинка </label>
                                <input type="file" class="form-control" name="news_image" id="news_image" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
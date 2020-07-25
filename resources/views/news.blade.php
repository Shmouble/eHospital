@extends('layouts.app')

@section('content')
    <div class="stuff">
        <a href="#" id="addNews" data-toggle="modal" data-target="#addNewsModal">
            <h4>Add News</h4>
        </a>
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
                                <input type="text" class="form-control" name="news_title" id="news_title">
                            </div>
                            <div class="form-group">
                                <label for="news_text"> Текст: </label>
                                <textarea rows="10" type="text" class="form-control textfield" name="news_text" id="news_text">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="news_image"> Картинка </label>
                                <input type="file" class="form-control" name="news_image" id="news_image">
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
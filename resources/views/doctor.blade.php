<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'eHospital') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
      
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles --> 
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
                </div>
            @endif
            <!-- Карточка доктора -->
            <div class="content">
                <div class="title m-b-md">
                    <a href="#" id="editImage" data-toggle="modal" data-target="#editImgModal">
                        <img class="img-thumbnail" id="docImg" src="{{ asset('storage/' . $doctor->img_url) }}">
                    </a>
                    <p>
                        <span id="docName"> {{ $doctor->name }} </span>
                        <a href="#" id="editPencil" data-toggle="modal" data-target="#editDocModal">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </p>    
                </div>

                <div class="links">
                    <p id="docEducation" >Образование: {{ $doctor->education }} </p><br>
                    <p id="docExperience">Опыт работы: {{ $doctor->experience }} </p>
                </div>
            </div>
        </div>
        <!-- Календарь -->
        <div id='calendar'></div>
        <!-- Модальное окно для редактирования инфо о докторе -->
        <div class="modal fade" id="editDocModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Изменить информацию</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="editDocForm">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name"> ФИО </label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="education"> Образование: </label>
                                    <input type="text" class="form-control" name="education" id="education">
                                </div>
                                <div class="form-group">
                                    <label for="experience"> Опыт работы: </label>
                                    <input type="text" class="form-control" name="experience" id="experience">
                                </div>
                                <input type="hidden" name="id">
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" id="btn-update" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модальное окно изменения аватара доктора --> 
        <div class="modal fade" id="editImgModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Изменить фотографию</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="editImgForm" enctype="multipart/form-data">
                            <div class="card-body">
                                    <div class="form-group">
                                        <label for="image"> Выберите изображение </label>
                                        <input type="file" name="image" class="form-control-file" id="image">
                                        <img id="load" class="img" src="{{ asset('storage/storage/qhvOC.gif') }}">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" id="btn-update" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        <!-- Модальное окно добавления расписания -->
        <div class="modal fade" id="addEventModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавить расписание</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="addEventForm">
                            <div class="card-body">
                                    <div class="form-group">
                                        <label for="num_patients"> Количество приемов: </label>
                                        <input type="number" min=1 max=50 class="form-control" name="num_patients" id="num_patients">
                                    </div>

                                    <div class="form-group">
                                        <label for="start"> Начало смены: </label>
                                        <input class="form-control timepicker" name="start" id="start">
                                    </div>

                                    <div class="form-group">
                                        <label for="end"> Конец смены: </label>
                                        <input class="form-control timepicker" name="end" id="end">
                                    </div>
                                    <input type="hidden" id="date" name="date">
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" id="btn-update" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>

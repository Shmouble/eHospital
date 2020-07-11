@extends('app')

@section('content')
    <script>
        var isRoot = {{ (Auth::user()->hasRole('manager.hospital')) }}
    </script>


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

                    @role('root.hospital')
                    <a href="#" id="editImage" data-toggle="modal" data-target="#editImgModal">
                        <img class="img-thumbnail" id="docImg" src="{{ asset('storage/' . $doctor->img_url) }}">
                    </a>
                    @else
                        <img class="img-thumbnail" id="docImg" src="{{ asset('storage/' . $doctor->img_url) }}">
                    @endrole

                    <p>
                        <span id="docName"> {{ $doctor->name }} </span>
                        @role('root.hospital')
                            <a href="#" id="editPencil" data-toggle="modal" data-target="#editDocModal">
                                <i class="fa fa-pencil"></i>
                            </a>
                        @endrole
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
                                <input type="submit" class="btn btn-primary" id="doc-update" value="Сохранить">
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
                                <input type="submit" class="btn btn-primary" id="avatar-update" value="Сохранить">
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
                        <h4 class="modal-title"></h4>
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
                                    <input type="hidden" id="schedule_id" name="schedule_id">
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" id="event-update" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
@endsection    
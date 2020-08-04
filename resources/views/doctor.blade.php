@extends('layouts.app')

@section('content')
    
@auth
    <script>
        //var isRoot = {{ (Auth::user()->hasRole('manager.hospital')) }}; 
    </script>
@endauth
            <!-- Карточка доктора -->

<div class="row about">
   <div class="col-lg-4 col-md-4 col-sm-12">
    @role('root.hospital')
                    <a href="#" id="editImage" data-toggle="modal" data-target="#editImgModal">
                        <img class="img-thumbnail" id="docImg" src="{{ asset('storage/' . $doctor->img_url) }}">
                    </a>
                    @else
                        <img class="img-thumbnail" id="docImg" src="{{ asset('storage/' . $doctor->img_url) }}">
                    @endrole
   </div>
   <div class="col-lg-8 col-md-8 col-sm-12 desc">
     
    <h3 id="docName"> {{ $doctor->name }} </h3>
    @role('root.hospital')
                            <a href="#" id="editPencil" data-toggle="modal" data-target="#editDocModal">
                                <i class="fa fa-pencil"></i>
                            </a>
                        @endrole
    <p id="docEducation" >Образование: {{ $doctor->education }} </p><br>
    <p id="docExperience">Опыт работы: {{ $doctor->experience }} </p>
    <p></p>
   </div>
  </div>
  @if (!Auth::check()) 
<div class="alert alert-danger" role="alert">
  Пожалуйста, для заказа талона авторизуйтесь!
</div>
       @endif
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
        <!-- Модальное окно для вывода свободных талонов -->
        <div class="modal fade" id="freeTickModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Номер талона</th>
                                        <th>Время</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="freetickets">
                                </tbody>
                            </table>
                        </div>
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
                                        <label for="num_tickets"> Количество приемов: </label>
                                        <input type="number" min=1 max=50 class="form-control" name="num_tickets" id="num_tickets">
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
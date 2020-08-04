@extends('layouts.app')

@section('content')
<h4>{{ $department->name }}</h4>
@role('root.hospital')
<button type="button" class="btn btn-warning add" data-toggle="modal" data-target="#addDocModal">Добавить доктора</button>
<div class="row">
@endrole
 @foreach($doctors as $doctor)
  <div class="col-sm-3" data-id="{{ $doctor->id }}">
    <div class="card">
      <img class="card-img-top" src="{{ asset('storage/' . $doctor->img_url) }}" alt="Doctor image">
      
      <div class="card-body">
        <h5 class="card-title">{{ $doctor->name }}</h5>
        <p class="card-text">{{ $doctor->education }}</p>
        <p class="card-text">{{ $doctor->experience }}</p>
        <a href="{{ url('doctor/' . $doctor->id) }}" class="btn btn-secondary">Подробнее</a>

        @role('root.hospital')
            <button type="button" id='deleteBtn' data-id="{{ $doctor->id }}" class="close deleteBtn" data-toggle="modal" data-target="#deleteModal">Удалить</button>
        @endrole

      </div>
    </div>
  </div>
 @endforeach
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Подтвердите</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Вы точно хотите удалить доктора?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger confirm">Удалить</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addDocModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавить доктора</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <form id="addDocForm">
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
                        <input type="hidden" id="department_id" name="department_id" value="{{ $department->id }}">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" id="doc-create" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
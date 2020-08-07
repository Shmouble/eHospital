@extends('layouts.app')

@section('content')
       
        
            <div class="row about">
   <div class="col-lg-4 col-md-4 col-sm-12">            
        <img class="img-thumbnail" id="docImg" src="{{ asset('storage/' . $doctor->img_url) }}">
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
   </div>
  </div>

    <table class="table table-hover"><h3>Расписание</h3>
  <thead>
    <tr>
      <th scope="col">Дата</th>
      <th scope="col">Начало приема</th>
      <th scope="col">Конец приема</th>
      <th scope="col">Количество талонов</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
   @foreach($schedules as $schedule)
    <tr>
      <td> {{ \Carbon\Carbon::parse($schedule->start)->format('d M Y') }}</td>
      <td> {{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}</td>
      <td> {{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}</td>
      <td> {{$schedule->num_tickets}}</td>
      <td><a id='openTickets' class='btn btn-primary' data-toggle="modal" data-target="#ticketsModal"data-date='{{ \Carbon\Carbon::parse($schedule->start)->format('d M Y') }}' data-id='{{ $schedule->id }}'>Подробнее</a></td>
    </tr>
@endforeach
  </tbody>
</table>
                 
                
            </div>
        </div>
<div id="ticketsModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="classModalLabel"></h4>
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button>
        
      </div>
      <div class="modal-body">
        <table id="classTable" class="table table-bordered">
          <thead>
          <th>Номер талона</th>
          <th>Время</th>
          <th>Пациент</th>
          </thead>
          <tbody class=tickets>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">
          Закрыть
        </button>
      </div>
    </div>
  </div>
</div> 
@endsection    
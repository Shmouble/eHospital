@extends('app')

@section('content')
       
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
                    <img class="img-thumbnail" id="docImg" src="{{ asset('storage/' . ($doctor->img_url ?? '')) }}">
                    <p>
                        <span id="docName"> {{ $doctor->name ?? '' }} </span>
                    </p>    
                </div>

                <div class="links">
                    <p id="docEducation" >Образование: {{ $doctor->education ?? ''}} </p><br>
                    <p id="docExperience">Опыт работы: {{ $doctor->experience ?? ''}} </p>
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
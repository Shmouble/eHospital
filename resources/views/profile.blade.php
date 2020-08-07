@extends('layouts.app')

@section('content')
        
<div class="nav flex-column flex-sm-row nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">My profile</a>
  <a class="nav-link" id="v-pills-tickets-tab" data-toggle="pill" href="#v-pills-tickets" role="tab" aria-controls="v-pills-tickets" aria-selected="false">My tickets</a>
</div>
<div class="tab-content" id="v-pills-tabContent">
  <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
  <div class="row about">
   <div class="col-lg-4 col-md-4 col-sm-12">
     <img class="img-thumbnail" id="docImg" src="">
   </div>
   <div class="col-lg-8 col-md-8 col-sm-12 desc"> 
    <h3 id="docName"> {{ $patient->name . ' ' .  $patient->surname }} </h3>
    <p id="docEducation" >Дата рождения: {{ $patient->birthdate }} </p><br>
   </div>
  </div>
</div>
  <div class="tab-pane fade" id="v-pills-tickets" role="tabpanel" aria-labelledby="v-pills-tickets-tab">
    <table class="table table-hover"><h3>Талоны</h3>
      <thead>
        <tr>
          <th scope="col">Номер талона</th>
          <th scope="col">Дата</th>
          <th scope="col">Время приема</th>
          <th scope="col">Врач</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
       @foreach($tickets as $ticket)
        <tr id='{{ $ticket->id }}'>
          <td> {{ $ticket->number }}</td>
          <td> {{ \Carbon\Carbon::parse($ticket->start)->format('d.m.Y') }}</td>
          <td> {{ \Carbon\Carbon::parse($ticket->time)->format('H:i') }}</td>
          <td><a href={{ url("/doctor/$ticket->doctor_id") }}> {{ $ticket->doctor_name }}</a></td>
          <td><a id='deleteTickets' class='btn btn-primary' data-id='{{ $ticket->id }}' >Отменить</a></td>
        </tr>
       @endforeach
      </tbody>
    </table>
 </div>
</div>                 

@endsection    
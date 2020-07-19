<?php
namespace App\Http\Controllers;

use App\Schedule;
use App\Ticket;
use App\Patient;
use Illuminate\Http\Request;
use Redirect,Response;
use DateTime;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function patientsTickets(Request $request)
    {
        $id = $request->user()->id;
        
        $tickets = Patient::where('patients.user_id', $id)->join('tickets','tickets.patient_id', '=', 'patients.id' )->join('schedules','tickets.schedule_id', '=', 'schedules.id' )->join('doctors', 'doctors.id', '=', 'schedules.doctor_id')->select('tickets.number','tickets.time', 'doctors.name')->get();

        return Response::json($tickets);
    } 
    
    public function doctorsTickets(Request $request, $schedule)
    {
        $tickets = Ticket::where('schedule_id', $schedule)->join('patients', 'patients.id', '=', 'tickets.patient_id')
            ->select('tickets.number','tickets.time', 'patients.name', 'patients.surname')->get();

        return Response::json($tickets);
    }
    
    public function store(Request $request, $doctor)
    {
        $start = new DateTime(($request->date) . ($request->start));
        $end = new DateTime(($request->date) . ($request->end));
        $insert = [ 'num_tickets' => $request->num_tickets,
            'start' => $start,
            'end' => $end,
            'doctor_id' => $doctor
            ];
        $schedule = Schedule::create($insert);
        return Response::json($schedule);
    }
    
    public function freeTickets($doctor)
    {
        
        $tickets = [];
        $nowDate = Carbon::now();
        $schedules = Schedule::where('start', '>', $nowDate)->where('doctor_id', $doctor)->get()->sortBy('start');
        foreach ($schedules as $schedule){
            $start = Carbon::parse($schedule->start);
            $end = Carbon::parse($schedule->end);
            $numTickets = $schedule->num_tickets;
            $minForOneTicket = ($end->diffInMinutes($start))/($numTickets);
            $currentTicketTime = $start;
            for($i = 1; $i<=$numTickets; $i++){
                $ticketTime = $currentTicketTime->format('H:i');
                $tickets[$i] = $ticketTime;
                $currentTicketTime = $currentTicketTime->addMinutes($minForOneTicket);
                
            }
            $takenTickets = Ticket::where('schedule_id', $schedule->id)->get();
            foreach($takenTickets as $takenTicket){
                if( array_key_exists($takenTicket->number, $tickets)){
                    unset($tickets[$takenTicket->number]);
                }
            }
        }
       return Response::json($tickets);
    }
    
    public function destroy(Request $request, $doctor, Schedule $schedule)
    {
        $schedule->delete();
        return Response::json($schedule);
    }
}
<?php
namespace App\Http\Controllers;

use App\Schedule;
use App\Ticket;
use App\Patient;
use Illuminate\Http\Request;
use Redirect,Response;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    
    public function patientsTickets(Request $request)
    {
        $id = Auth::id();
        $patient = Patient::where('patients.user_id', $id)->first();
        $tickets = Patient::where('patients.user_id', $id)->join('tickets','tickets.patient_id', '=', 'patients.id' )->join('schedules','tickets.schedule_id', '=', 'schedules.id' )->join('doctors', 'doctors.id', '=', 'schedules.doctor_id')->select('tickets.id','tickets.number','schedules.start', 'tickets.time', 'doctors.name as doctor_name', 'doctors.id as doctor_id')->get();

        return view ('profile', compact(['tickets', 'patient']))->with('title', 'Мой профиль');
    } 
    
    public function doctorsTickets(Request $request, $schedule)
    {
        $tickets = Ticket::where('schedule_id', $schedule)->join('patients', 'patients.id', '=', 'tickets.patient_id')
            ->select('tickets.number','tickets.time', 'patients.name', 'patients.surname')->get();

        return Response::json($tickets);
    }
    
    public function store(Request $request, $schedule)
    {
        $id = Auth::id();
        $patient = Patient::where('patients.user_id', $id)->first();
        $insert = [ 'number' => $request->number,
            'time' => $request->time,
            'schedule_id' => $schedule,
            'patient_id' => $patient->id
            ];
        $ticket = Ticket::create($insert);
        return Response::json($ticket);
    }
    
    public function freeTickets(Schedule $schedule)
    {
        
        $tickets = [];
        $nowDate = Carbon::now();
        
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
       return Response::json($tickets);
    }
    
    public function numberOfFreeTickets($doctor)
    {
        
        $tickets = [];
        $nowDate = Carbon::now();
        $schedules = Schedule::where('start', '>=', $nowDate)->where('doctor_id', $doctor)->get()->sortBy('start');
        foreach ($schedules as $schedule){
            $date = Carbon::parse($schedule->start)->format('Y-m-d');
            $numberOfAllTickets = $schedule->num_tickets;
            $numberOfTakenTickets = Ticket::where('schedule_id', $schedule->id)->get()->count();
            $numberOfFreeTickets = $numberOfAllTickets - $numberOfTakenTickets;
            $tickets[$date] = ['number' => $numberOfFreeTickets,'id' => $schedule->id];
        }
       return Response::json($tickets);
    }
    
    public function destroy(Request $request, Ticket $ticket)
    {
        $ticket->delete();
        return Response::json($ticket);
    }
}
<?php
namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use Redirect,Response;
use DateTime;

class ScheduleController extends Controller
{
    public function index($doctor)
    {
        $data = Schedule::where('doctor_id', $doctor)->get(['id', 'num_patients AS title', 'start', 'end']);

        return Response::json($data);
    }
    
    public function store(Request $request, $doctor)
    {
        $start = new DateTime(($request->date) . ($request->start));
        $end = new DateTime(($request->date) . ($request->end));
        $insert = [ 'num_patients' => $request->num_patients,
            'start' => $start,
            'end' => $end,
            'doctor_id' => $doctor
            ];
        $schedule = Schedule::insert($insert);
        return Response::json($schedule);
    }
    
    public function update(Request $request, $doctor)
    {
        $start = new DateTime(($request->date) . ($request->start));
        $end = new DateTime(($request->date) . ($request->end));
        $update = [ 'num_patients' => $request->num_patients,
            'start' => $start,
            'end' => $end,
            ];
        $schedule  = Schedule::where('id',$request->id)->update($update);
        return Response::json($schedule);
    }
    
    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
        return Response::json($event);
    }
}
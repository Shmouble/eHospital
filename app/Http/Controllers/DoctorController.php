<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\Schedule;
use App\Department;
use Redirect,Response;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $doctors = Doctor::where('department_id', $department->id)->get(['id', 'name', 'education', 'experience', 'img_url']);
        return view ('department', compact(['doctors', 'department']))->with('title', $department->name);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'education' => 'required',
           'experience' => 'required',
        ]);
         
        $create = $request->all();
        $doctor =Doctor::create($create);
        
        return Response::json($doctor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        return view ('doctor', compact('doctor'))->with('title', $doctor->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        return Response::json($doctor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
       $request->validate([
            'name' => 'required',
            'education' => 'required',
           'experience' => 'required',
        ]);
         
        $update = $request->only('name', 'education', 'experience');
        $doctor->update($update);
        
        return Response::json($doctor);
    }
    
    public function cabinet(Request $request)
    {
       $id = $request->user()->id;
        $nowDate = Carbon::now();
        $endDate = Carbon::now()->addDays(10);
        $doctor = Doctor::where('user_id', $id)->first();
        $schedules = $doctor->schedules()->whereBetween('start', [$nowDate, $endDate])->get()->sortBy('start');
        
        return view ('cabinet', compact(['doctor', 'schedules']));
    }
    
    public function image(Request $request, Doctor $doctor)
    {
       $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $path = $request->file('image')->store('storage', 'public');

        $doctor->img_url = $path;
        $doctor->update();
        
        return Response::json($path);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return Response::json($doctor);
    }
}

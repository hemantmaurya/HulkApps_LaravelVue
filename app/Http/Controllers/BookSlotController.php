<?php

namespace App\Http\Controllers;

use App\Models\BookSlot;
use Illuminate\Http\Request;

class BookSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(BookSlot::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json(BookSlot::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookSlot  $bookSlot
     * @return \Illuminate\Http\Response
     */
    public function show(BookSlot $bookSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookSlot  $bookSlot
     * @return \Illuminate\Http\Response
     */
    public function edit(BookSlot $bookSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookSlot  $bookSlot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookSlot $bookSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookSlot  $bookSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookSlot $bookSlot)
    {
        //
    }

    public function doctorList()
    {
        return response()->json(BookSlot::get());
    }

    public function fetchTimeSlots($id)
    {
        $bookedTime = $timeList = array();
        $times = BookSlot::where('doctor', $id)->get();
        
        foreach($times as $time){
            $bookedTime[] = $time->time;
        }
        for($i=1;$i<25;$i++){
            $timeList[] = $i;
        }

        $final_time = array_diff($timeList, $bookedTime);

        return response()->json($final_time);
    }
    
    public function confirm($id)
    {
        $bookSlot = BookSlot::find($id);

        $bookSlot->confirmation = 1;
        $bookSlot->update();
        return response()->json(BookSlot::get());
    }
}

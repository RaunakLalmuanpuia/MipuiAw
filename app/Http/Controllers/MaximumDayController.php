<?php

namespace App\Http\Controllers;

use App\Models\MaximumDay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaximumDayController extends Controller
{
 
    public function index()
    {
        $maximumDay = MaximumDay::all();
       

        return Inertia::render('Auth/System/MaximumDay/Index',[
            'maximumDay' => $maximumDay,
        ]);
    }

 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MaximumDay $maximumDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaximumDay $maximumDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaximumDay $maximumDay)
    {
        //
        $maximumDay = MaximumDay::where('id', $request->id)->first();
        $maximumDay->maximum_days = $request->maximumDay;
        $maximumDay->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaximumDay $maximumDay)
    {
        //
    }
}

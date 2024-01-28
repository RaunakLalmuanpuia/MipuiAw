<?php

namespace App\Http\Controllers;

use App\Models\MonthlyCredit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonthlyCreditController extends Controller
{

    public function index()
    {
        return Inertia::render('Auth/System/MonthlyLimit/Index',[
            'monthly_limit' => MonthlyCredit::all(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(MonthlyCredit $monthlyCredit)
    {
        //
    }

    public function edit(MonthlyCredit $monthlyCredit)
    {
        //
    }

    public function update(Request $request, MonthlyCredit $monthlyCredit)
    {
        $monthlyCredit = MonthlyCredit::find($request->id);
        $monthlyCredit->monthly_limit = $request->monthly_limit;
        $monthlyCredit->save();

        return redirect()->back()->with('message','Monthly Limit update successfully');    

    }

    public function destroy(MonthlyCredit $monthlyCredit)
    {
        //
    }
}

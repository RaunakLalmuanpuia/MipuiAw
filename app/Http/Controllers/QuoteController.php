<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuoteController extends Controller
{

    public function index()
    {
        $quotes=Quote::orderBy('quote','ASC')->get();
        return Inertia::render('Auth/Quote/Index',[
            'quotes'=> $quotes,
        ]);
    }

    public function create()
    {
        return Inertia::render('Auth/Quote/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'quote'=>'required',
            'speaker'=>'required',
        ]);

        $quote = new Quote();
        $quote->quote=$request->quote;
        $quote->speaker=$request->speaker;
        $quote->save();

        return to_route('quote.index')->with('message','Quote saved successfully!');
    }

    public function show(Quote $quote){}
    public function edit(Quote $quote){}

    public function update(Request $request, Quote $quote)
    {
        $request->validate([
            'quote'=>'required',
            'speaker'=>'required',
        ]);

        $quote = Quote::find($quote->id);
        $quote->quote=$request->quote;
        $quote->speaker=$request->speaker;
        $quote->save();
        return redirect()->back()->with('message','Quote update successfully');    

    }

    public function destroy(Quote $quote)
    {
        $quote = Quote::where('id',$quote->id)->delete();

        return to_route('quote.index')->with('message','Quote Delete Successfully');
 
    }
}

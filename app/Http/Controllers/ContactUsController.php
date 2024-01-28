<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;

class ContactUsController extends Controller
{
    public function contactUs(Request $request){
    
        $validation = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required|digits:10|numeric',
            'subject'=>'required',
            'message'=>'required|max:400',
        ]);
        
        if($request->honeypot!=null){
            //CHECK IF BOT
            return back();
        }
        $contactUs = new ContactUs();

        $contactUs->name= $request->name;
        $contactUs->email= $request->email;
        $contactUs->phone= $request->phone;
        $contactUs->subject= $request->subject;
        $contactUs->message= $request->message;
        
        $contactUs->source=$request->source;

        $contactUs->save();
        
        return redirect()->back()->with('message','Feedback submit successfully!');
        


    }

    public function index(Request $request)
    {
        
        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10;
 

        $feedbacks = ContactUs:: 
            where(function($query) use($SEARCH){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('name','LIKE',"%$SEARCH%")
                    ->orWhere('email','LIKE',"%$SEARCH%")
                    ->orWhere('phone','LIKE',"%$SEARCH%")
                    ->orWhere('subject','LIKE',"%$SEARCH%")
                    ->orWhere('message','LIKE',"%$SEARCH%");
            })->latest()->paginate($PER_PAGE);



        return Inertia::render('Auth/Feedback/Index',[
            'feedbacks'=>$feedbacks,
            'search' => $SEARCH

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

    public function show(ContactUs $contactUs)
    {
        //
    }

    public function edit(ContactUs $contactUs)
    {
        //
    }

    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    public function destroy($id)
    {
      
        $feedback = ContactUs::where('id',$id)->delete();

        return to_route('feedback.index')->with('message','Feedback Delete Successfully');
 
    }
}

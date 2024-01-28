<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActionController extends Controller
{ 
    public function index()
    {
        $actions = Action::all();
        return Inertia::render('Auth/Action/Index',[
            'actions'=>$actions,
        ]);
    }

    public function create()
    {
        return Inertia::render('Auth/Action/Create');
    }

    public function store(Request $request)
    {
        
        $validate=$request->validate([
            'label'=>'required',
            'name'=>'required',
            'visible'=>'required',

        ]);


        $action=new Action();
        $action->name=$request->name;
        $action->label=$request->label;
        $action->visible=$request->visible;

        $action->save();

        return to_route('action.index');

    }

    public function show(Action $action)
    {
        //
    }

    public function edit(Action $action)
    {
        //
    }

    public function update(Request $request, Action $action)
    {
        
        $validate=$request->validate([
            'label'=>'required',

        ]);
        $mAction = Action::find($action->id);
        $mAction->label = $request->label;
        $mAction->visible=$request->visible;

        $mAction->save();
    }

    public function destroy(Action $action)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\HomeText;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeTextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeText=HomeText::find(1);

        return Inertia::render('Auth/System/HomeText/Index', [
            'homeText' => $homeText
        ]);
    }

    public function create(){  }
    public function store(Request $request) { }
    public function show(HomeText $homeText) { }
    public function edit(HomeText $homeText){ }
    public function destroy(HomeText $homeText)  { }

    public function update(Request $request, HomeText $homeText)
    {
        $homeTextUpdate = HomeText::find(1);
        $homeTextUpdate->body1=$request['body1'];
        $homeTextUpdate->save();
    }

}

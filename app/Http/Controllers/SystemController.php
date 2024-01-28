<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class SystemController extends Controller
{
    public function Carousel(){
        $NO_OF_CAROUSEL=1;
        $carousels = Carousel::all();
        $imageFull = false;
        $imageCount = Carousel::where('visible',true)->count();
        if( $imageCount >= ($NO_OF_CAROUSEL)){
            $imageFull = true;
        }

        return Inertia::render('Auth/System/Carousel/Index',[
            'carousels'=> $carousels,
            'imageFull'=>$imageFull,
            'imageCount'=>$imageCount,

        ]);
    }

    public function carouselStore(Request $request){
        
        $NO_OF_CAROUSEL = 10;
        $validate = $request->validate([
            'image'=>['required','mimes:jpeg,png,jpg', 'max:12048'],
        ]);
     

        if(Carousel::where('visible',true)->count() >= ($NO_OF_CAROUSEL)){
            return redirect()->back()->withErrors([
                'maximum' => 'You have reached maximum number of carousel'
            ]);

        }

        $name = $request->file('image')->getClientOriginalName();
        $newName = Carbon::now()->timestamp.'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(storage_path('app/public').'/carousel/',$newName);
        
        $carousel = new Carousel();
        $carousel->name = $name;
        $carousel->image = $newName;
        $carousel->visible = $request->visible['value'] ;
 
        $carousel->save();

    }

    public function carouselUpdate(Request $request, $id){
        $NO_OF_CAROUSEL = 10;

        $carousel = Carousel::find($id);

        if($request->visible['value']==true){
            if(Carousel::where('visible',true)->count() >= ($NO_OF_CAROUSEL)){
                return redirect()->back()->withErrors([
                    'maximum' => 'You have reached maximum number of carousel'
                ]);
            }
        }
        
        if($request->file('image')!=null){
            $name = $request->file('image')->getClientOriginalName();
            $newName = Carbon::now()->timestamp.'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public').'/carousel/',$newName);
            $carousel->name = $name;
            $carousel->image= $newName;
        }
        $carousel->visible = $request->visible['value'];
        $carousel->save();
    }

    public function carouselDelete($id){
        
        Carousel::find($id)->delete();
    }
}

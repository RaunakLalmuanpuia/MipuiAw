<?php

namespace App\Http\Controllers;

use App\Models\GrievanceMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

class GrievanceMovementController extends Controller
{
    public function index() {  }
    public function create()  { }
    public function store(Request $request){ }
    public function show(GrievanceMovement $grievanceMovement) { }
    public function edit(GrievanceMovement $grievanceMovement){  }
    public function update(Request $request, GrievanceMovement $grievanceMovement) { }
    public function destroy(GrievanceMovement $grievanceMovement) { }

    public function movementOpen(Request $request){
        $CURRENT_USER = Auth::user();

        $grievanceMovement = GrievanceMovement::where('grievance_id',$request->grievance_id)->get();
        foreach($grievanceMovement as $gm){
            if($CURRENT_USER->role_id == 3){
                $gm->is_seen_by_department = Carbon::now()->toDateTimeString();
            }else if($CURRENT_USER->role_id == 4){
                $gm->is_seen_by_sub_department = Carbon::now()->toDateTimeString();
            }
            $gm->save();
        }

    }

    
}

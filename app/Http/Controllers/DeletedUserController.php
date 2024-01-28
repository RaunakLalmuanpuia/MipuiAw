<?php

namespace App\Http\Controllers;

use App\Models\DeletedUser;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class DeletedUserController extends Controller
{
    
    public function index(Request $request)
    {
        
        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10;
 

        $deletedUsers = DeletedUser::
            where(function($query) use($SEARCH){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('name','LIKE',"%$SEARCH%")
                    ->orWhere('email','LIKE',"%$SEARCH%")
                    ->orWhere('mobile','LIKE',"%$SEARCH%")
                    ->orWhere('district','LIKE',"%$SEARCH%");
            })->latest()->paginate($PER_PAGE);

        return Inertia::render('Auth/DeletedUser/Index',[
            'deletedUsers'=>$deletedUsers,
            'search' => $SEARCH

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
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
    public function show(DeletedUser $deletedUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeletedUser $deletedUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeletedUser $deletedUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletedUser $deletedUser)
    {
        //
    }
}

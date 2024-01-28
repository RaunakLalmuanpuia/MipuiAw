<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

use function Psy\debug;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Guest/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {


        
        $request->authenticate();
         
        $request->session()->regenerate();

        $user=  User::where('id',Auth::user()->id)->first();
       
        $user->last_login = Carbon::now()->toDateTimeString();
        $user->save();
        
        if(($user->role_id == 5))// ROLE : CITIZEN=5
        {
            return redirect()->route('citizen.dashboard');

        }else{
           
            //HAVE SOME ROLE          
            return redirect()->route('officer.dashboard');

            //return redirect()->intended(RouteServiceProvider::HOME);
        }
        

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

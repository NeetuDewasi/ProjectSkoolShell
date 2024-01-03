<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;
 public function activate($activationKey)
    {
        $user = School::where('activation_key', $activationKey)->first();

        if ($user) {
            // Activate the user's account
            $user->update(['activation_key' => null, 'is_active' => true]);
        }
    }

    protected function redirectTo()
    {
        if (auth()->user()->role->role == 'admin' || auth()->user()->role->role == "Administrator") {
            return '/admin/dashboard';
        }else if (auth()->user()->role->role == 'school') {
            return '/school/dashboard';
        }
        return '/admin/dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

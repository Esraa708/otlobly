<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        // dd($user);
        $this->createOrCheck($user->name, $user->email, $user->avatar);
        // return redirect()->route('home');
    }
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackGoogle()
    {
        $user = Socialite::driver('google')->user();
        $this->createOrCheck($user->name, $user->email, $user->avatar);
        return redirect()->route('home');
    }
    public function createOrCheck($name, $email, $avatar)
    {
        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->picture = $avatar;
        $newUser->password = bcrypt(123456);
        $checkUser = User::firstWhere('email', $newUser->email);
        if ($checkUser) {
            auth()->login($checkUser, true);
            // return redirect()->route('home');
        } else {
            $newUser->save();
            auth()->login($newUser, true);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd($data);
        // $path = $request->file('picture')->store('avatars');
        // dd($path);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'picture' => $data['picture'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->createOrCheck($user->name, $user->email, $user->avatar);
        return redirect()->route('home');
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

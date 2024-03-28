<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    // protected $redirectTo = '/dashboard'; // Définissez la route appropriée
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

    protected function authenticated(Request $request)
    {
        
        $user = $request->user();
        // dd($user);
        $token = $user->createToken('MyAppToken')->accessToken;
        session(['access_token' => $token]);

    }

public function logout(Request $request)
{
    if ($request->user()) {
        $user = $request->user();
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }
    $this->guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    $response = redirect('/');

    $response->headers->setCookie(cookie()->forget('laravel_session'));

    return $response;
}


}

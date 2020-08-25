<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Socialite;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->get('username'))->first();

        // Check Condition Mobile No. Found or Not
        if(!isset($user)) {
            \Session::put('errors', 'Username tidak ditemukan !!');
            return back();
        } else {

            if($user->role_id == '1'){
                $this->validateLogin($request);

                // If the class is using the ThrottlesLogins trait, we can automatically throttle
                // the login attempts for this application. We'll key this by the username and
                // the IP address of the client making these requests into this application.
                if (method_exists($this, 'hasTooManyLoginAttempts') &&
                    $this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);

                    return $this->sendLockoutResponse($request);
                }

                if ($this->attemptLogin($request)) {
                    return $this->sendLoginResponse($request);
                }

                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponse($request);

            } else {
                \Auth::login($user);
                return redirect('infoseminar');
            }

        }

    }

    public function showLoginForm(){
        return view('login');
    }

    public function username(){
        return 'username';
    }

    protected function authenticated()
    {
        if (Auth::user()->role_id == 2 ){
            return redirect('infoseminar');
        }
        if (Auth::user()->role_id == 1){
            return redirect('/');
        }
        $user = Auth::user();
        $user->last_login = date("Y-m-d H:i:s");
        $user->save();
    }

    public function redirectToProvider()
    {
        // dd(Socialite::driver('google'));
        return Socialite::driver('google')
        ->scopes([
                'openid',
                'profile',
                'email',
                'user.phonenumbers.read',
                'user.organization.read',
            ])
        ->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $authUser = $this->findOrCreateUser($user, 'google');
        Auth::login($authUser, true);
        return redirect('/');
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        else{
            dd($user);
            $data = User::create([
                'name'     => $user->name,
                'username' => $user->name,
                'email'    => !empty($user->email)? $user->email : '' ,
                'provider' => $provider,
                'provider_id' => $user->id
            ]);

            return $data;
        }
    }
}

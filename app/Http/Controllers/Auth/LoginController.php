<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Peserta;
use App\ResetModel;
use Socialite;
use File;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Session;
use App\TargetBlasting;


use App\Mail\MailResetPassword;
use App\Mail\MailResetSukses;
use Mail;


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
            return redirect()->back()->with(['is_login' => 'Username tidak ditemukan !!']);
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

                $this->validate($request, [
                    'username' => 'required|string',
                    'password' => 'required|string'
                ]);

                $login = [
                    'username' => $request->username,
                    'password' => $request->password
                ];

                //LAKUKAN LOGIN
                if (auth()->attempt($login)) {

                    $data = User::find($user->id);
                    $data->is_login = 1;
                    $data->save();

                    if ($user->role_id == 5 || $user->role_id == 3){
                        return redirect('/dashboard');
                    } else {
                        if($user->is_login == 0) {
                            $data = User::find($user->id);
                            $data->is_login = 1;
                            $data->save();

                            \Auth::login($user);
                            return redirect('infoseminar');
                        } else{
                            // Session::flush();
                            return redirect()->back()->with(['is_login' => 'Akun anda sudah login di perangkat lain, silahkan logout dari perangkat sebelumnya.!!']);
                        }
                    }
                }

                //JIKA SALAH, MAKA KEMBALI KE LOGIN DAN TAMPILKAN NOTIFIKASI
                return redirect()->back()->with(['is_login' => 'Email/Password salah!']);
            }
        }
    }

    public function logout(Request $request){
        $user = User::where('id', Auth::id())->first();
        $role = Auth::user()->role_id;
        $data = User::find($user->id);
        $data->is_login = 0;
        $data->save();

        Session::flush();
        Auth::logout();
        // if($role == 2){
        //     return redirect('/');
        // }
        // if($role == 1){
        //     return redirect('/');
        // }
        // if($role == 5){
        //     return redirect('/');
        // }
        return redirect('/');

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
        if (Auth::user()->role_id == 1 ||Auth::user()->role_id == 5){
            return redirect('/dashboard');
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
                'https://www.googleapis.com/auth/user.phonenumbers.read',
                'https://www.googleapis.com/auth/user.organization.read',
            ])
        ->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $authUser = $this->findOrCreateUser($user, 'google');
        Auth::login($authUser, true);
        return redirect('/infoseminar');
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        else{
            // $data = User::create([
            //     'name'     => $user->name,
            //     'username' => !empty($user->email)? $user->email : $user->name,
            //     'email'    => !empty($user->email)? $user->email : '' ,
            //     'provider' => $provider,
            //     'provider_id' => $user->id,
            //     'role_id'  => '2',
            // ]);
            $udahAda = User::where('email', $user->email)->first();
            if($udahAda) {
                $data = User::where('email', $user->email)->first();
                $data->provider = 'google';
                $data->provider_id = $user->id;
                $data->save();
            } else {
                $data = new User;
                $data->name         = $user->name;
                $data->username     = !empty($user->email)? $user->email : $user->name;
                $data->email        = !empty($user->email)? $user->email : '';
                $data->provider     = $provider;
                $data->provider_id  = $user->id;
                $data->role_id      = '2';
                $data->save();

                $target = new TargetBlasting;
                $target->nama  = $user->name;
                $target->email  = $user->email;
                // $target->no_hp  = $request->hp_pimp;
                $target->save();

                // handle upload Foto
                $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $user->name);
                $foto = '';
                if ($user->avatar) {
                    $destinationPath = 'uploads/peserta/'.$dir_name; // upload path
                    if (!is_dir($destinationPath)) {
                        File::makeDirectory($destinationPath, $mode = 0777, true, true);
                    }
                    $file = "foto_".$dir_name.Carbon::now()->timestamp. "." . 'png';
                    $destinationFile = $destinationPath."/".$file;
                    $destinationPathTemp = 'uploads/tmp/'; // upload path temp
                    $resize_image = Image::make($user->avatar);
                    $resize_image->resize(354, 472)->save(public_path($destinationPathTemp.$file));
                    $temp = $destinationPathTemp.$file;
                    rename($temp, $destinationFile);
                    $foto = $dir_name.'/'.$file;
                }
            }

            $cekPeserta = Peserta::where('user_id', $data->id)->first();
            if($cekPeserta){
                //
            } else {

                $peserta = new Peserta;
                $peserta->user_id = $data->id;
                $peserta->nama    = $user->name;
                $peserta->email   = !empty($user->email)? $user->email : '';
                $peserta->foto    = $foto;
                $peserta->save();

            }

            return $data;
        }
    }

    public function forgetPassword(){
        return view('profile.reset-password');
    }

    public function postForgetPassword(Request $request) {
        // Validasi email user
        // dd($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,username'
        ]);

        $user = User::where('username', $request->email)->first();

        //check if payload is valid before moving on
        if ($validator->fails() || empty($user)) {
            return redirect()->back()->withErrors(['email' => 'Email tidak terdaftar di sistem kami']);
        }

        $reset = ResetModel::where('user_id', $user->id)->first();

        if(empty($reset)) {
            $reset = new ResetModel();
            $reset->user_id = $user->id;
            $reset->token = str_random(60);
            $reset->created_by = $user->id;
            $reset->updated_by = $user->id;
            $reset->created_at = \Carbon\Carbon::now()->toDateTimeString();
            $reset->save();
        } else {
            $reset->token = str_random(60);
            $reset->created_by = $user->id;
            $reset->updated_by = $user->id;
            $reset->created_at = \Carbon\Carbon::now()->toDateTimeString();
            $reset->save();
        }

        try {
            $details = [
                'reset' => $reset,
                'user' => $user
            ];
            $email = new MailResetPassword($details);
            Mail::to($user->username)->send($email);
            $reset->is_sent = 1;
            $reset->save();
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors(['email' => 'Sistem error, silahkan hubungi admin.']);
            $reset->is_sent = 2;
            $reset->save();
        }

        return redirect()->back()->with(['done' => "Link untuk mereset password berhasil dikirim silahkan cek email Anda"]);

    }

    public function resetPassword(Request $request, $token) {
        if (empty($token)) {
            return view('profile.reset-password')->with(['err_message' => 'Token tidak valid.']);
        } else if (strlen($token) != 60) {
            return view('profile.reset-password')->with(['err_message' => 'Token tidak valid.']);
        } else {
            $reset = ResetModel::where('token', $token)->first();

            if(empty($reset)) {
                return view('profile.reset-password')->with(['err_message' => 'Token tidak valid.']);
            }

            $check_date = \Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($reset->created_at)->addMinutes(30));

            if($check_date) {
                return view('profile.reset-password')->with(['err_message' => 'Link kadaluwarsa, silahkan ulangi permintaan reset.']);
            }

            return view('profile.reset-password')->with(['token' => $token]);
        }
    }

    public function doReset(Request $request, $token) {
        if ($token != $request->token) {
            return view('profile.reset-password')->with(['err_do_reset' => 'Something wrong.']);
        }
        //Validate input
        $validator = $request->validate([
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ],[
            'password.required' => 'Mohon lengkapi form',
            'password.confirmed' => 'Pastikan password diulang dengan benar',
            'password.min' => 'Password minimal 8 karakter'
        ]);

        $password = $request->password;
        $reset = ResetModel::where('token', $token)->first();

        if (empty($reset)) {
            return view('profile.reset-password')->with(['err_message' => 'Token tidak valid.']);
        }

        $user = User::find($reset->user_id);

        if (empty($user)) {
            return view('profile.reset-password')->with(['err_message' => 'Token tidak valid.']);
        }

        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        try {
            $details = [
                'reset' => $reset,
                'user' => $user
            ];
            $email = new MailResetSukses($details);
            Mail::to($user->username)->send($email);
        } catch (\Throwable $th) {
        }

        return redirect()->back()->with(['done' => "Reset password sukses. Slahkan login dengan password yang baru."]);

    }

}

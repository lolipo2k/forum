<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


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

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
        $this->activeTemplate = activeTemplate();
    }

    public function showLoginForm()
    {
        $pageTitle = "Login";
        return view($this->activeTemplate . 'user.auth.login', compact('pageTitle'));
    }

    public function showNeuroLoginForm()
    {
        $pageTitle = "Авторизация через нейроскрайб";
        return view($this->activeTemplate . 'user.auth.neurologin', compact('pageTitle'));
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        if ($request->get("neuroscribe") != null) $this->loginFromNeuroscribe($request->get('username'), $request->get('password'));

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
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
    }

    public function findUsername()
    {
        $login = request()->input('username');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function logout()
    {
        $this->guard()->logout();

        request()->session()->invalidate();

        $notify[] = ['success', 'You have been logged out.'];
        return to_route('user.login')->withNotify($notify);
    }

    public function authenticated(Request $request, $user)
    {
        $user->tv = $user->ts == 1 ? 0 : 1;
        $user->save();
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',', $info['long']);
            $userLogin->latitude =  @implode(',', $info['lat']);
            $userLogin->city =  @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();

        return to_route('user.home');
    }

    private function loginFromNeuroscribe($username, $password)
    {
        if (!preg_match("/^[[:alnum:]]+$/", $username)) {
            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                return false;
            } else {
                $where = 'email';
            }
        } else {
            $where = 'username';
        }
        $num_rows = DB::connection('mysql2')->table('qa_user')->where($where, $username)->count();

        if ($num_rows >= 1) {
            $info = DB::connection('mysql2')->table('qa_user')->where($where, $username)->first();

            $db_password = $info->password_hash;

            $check = new User();

            $check = $check::where('email', $info->email)->first();

            if (isset($check->id)) {
                $check->password = Hash::make($password);
                $check->save();
                return true;
            };

            if (password_verify($password, $db_password)) {

                $user = new User();
                $user->email = $info->email;
                $user->password = Hash::make($password);
                $user->username = $info->username;
                $user->firstname = $info->name;
                $user->status = 1;
                $user->reg_step = 1;
                $user->ev = ($info->confirm == null) ? 1 : 0;
                $user->sv = 1;
                $user->ts = 0;
                $user->tv = 1;
                $user->save();

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\RequestLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function getFormLogin()
    {
        $optionsMeta = [
            'meta_title'       => 'Đăng khập',
            'meta_description' => '',
            'meta_keywords'    => '',
            'meta_image'       => '',
            'meta_robots'      => ''
        ];
        $metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

    	if (get_data_user('web')) return redirect()->route('get.user.update_info');
        return view('auth.login',compact('metaSeo'));
    }

    public function postLogin(RequestLogin $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $this->logLogin();
            if (get_data_user('web','status') == User::STATUS_BLOCK)
				return redirect()->route('get.view_block_user');

            return redirect()->to($this->redirectTo('login_redirect_to'));
        }

        \Session::flash('toastr', [
            'type'    => 'error',
            'message' => 'Sai thông tin tài khoản'
        ]);

        return redirect()->back();
    }

    protected function logLogin()
    {
        $log = get_agent();
        $historyLog = \Auth::user()->log_login;
        $historyLog = json_decode($historyLog,true) ?? [];
        $historyLog[] = $log;
        \DB::table('users')->where('id', \Auth::user()->id)
            ->update([
                'log_login' => json_encode($historyLog)
            ]);
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->to('/');
    }
}

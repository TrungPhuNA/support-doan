<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Account\ResetPasswordJob;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Requests\UserRequestNewPassword;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    public function getEmailReset()
    {
		$optionsMeta = [
			'meta_title'       => 'Lấy lại mật khẩu',
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

        return view('auth.passwords.email', compact('metaSeo'));
    }

    public function checkEmailResetPassword(Request $request)
    {
        $account = \DB::table('users')->where('email', $request->email)->first();
        if ($account) {
            // gửi email
            try{
				$token = Hash::make($account->email.$account->id);
				\DB::table('password_resets')
					->insert([
						'email' => $account->email,
						'token' => $token,
						'created_at' => Carbon::now()
					]);

				dispatch(new ResetPasswordJob($account))
					->onQueue('restart-password')
					->delay(Carbon::now()->addMinutes(1));

				\Session::flash('toastr', [
					'type'    => 'success',
					'message' => 'Đường dẫn lấy lại mật khẩu đã được gủi tới email của bạn. Xin vui lòng kiểm tra email'
				]);
			}catch (\Exception $exception){
            	\Log::error("[Error checkEmailResetPassword] ". $exception->getMessage());
				\Session::flash('toastr', [
					'type'    => 'error',
					'message' => 'Có lỗi xẩy ra. Liên hệ với admin để được hỗ trợ'
				]);
			}

            return redirect()->to('/');
        }

        return redirect()->back();
    }

    public function newPassword(Request $request)
    {
        $token = $request->_token;

        //Check tồn tại token 
        $checkToken = \DB::table('password_resets')
            ->where('token',$token)
            ->first();

        if (!$checkToken)  {
			\Session::flash('toastr', [
				'type'    => 'error',
				'message' => 'Không tồn tại _token. Liên hệ với admin để được hỗ trợ'
			]);
			return redirect()->to('/');
		}

        // Check xem time taoj token quá 3phút chưa 
        $now = Carbon::now();
        if ($now->diffInMinutes($checkToken->created_at) > 5) {
            \DB::table('password_resets')->where('email', $request->email)->delete();
			\Session::flash('toastr', [
				'type'    => 'error',
				'message' => 'Link đã hết hạn mời bạn gửi lại yêu cầu lấy lại mật khẩu'
			]);
            return redirect()->route('get.email_reset_password');
        }

        return view('auth.passwords.reset'); 
    }

    public function savePassword(UserRequestNewPassword $request)
    {
        $password = $request->password;

        $data['password']   =  Hash::make($password);
        $email = $request->email;

        if (!$email) return redirect()->to('/');

        \DB::table('users')->where('email', $email)
            ->update($data);

        \DB::table('password_resets')->where('email', $email)->delete();

		\Session::flash('toastr', [
			'type'    => 'success',
			'message' => 'Thay đổi mật khẩu thành công. Mời bạn đăng nhập'
		]);

        return redirect()->route('get.login');
    }
}

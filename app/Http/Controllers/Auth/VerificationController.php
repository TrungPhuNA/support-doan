<?php

namespace App\Http\Controllers\Auth;

use App\HelpersClass\ContactHelper;
use App\Http\Controllers\Controller;
use App\Jobs\Account\VeryAccountJob;
use App\Mail\RegisterSuccess;
use App\User;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

//use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function renderViewVerificationAccount(Request $request)
	{
		$token = $request->_token;
		$idUser = $this->getIdUser($token);

		if ($idUser){
			$user = User::findOrFail($idUser);
			$user->status = User::STATUS_ACTIVE;
			$user->save();

			\Session::flash('toastr', [
				'type'    => 'success',
				'message' => 'Xác nhận tài khoản thành công'
			]);

			return redirect()->route('get.user.update_info');
		}

		\Session::flash('toastr', [
			'type'    => 'error',
			'message' => 'Xác nhận thất bại. Không tồn tại user xác nhận'
		]);

		return redirect()->to('/');
	}

	public function confirmationVerificationAccount($slug)
	{
		$idUser = $this->getIdUser($slug);
		if ($idUser)
		{
			$user = User::findOrFail($idUser);
			if ($user->status == User::STATUS_ACTIVE)
			{
				\Session::flash('toastr', [
					'type'    => 'success',
					'message' => 'Tài khoản này đã được xác thực'
				]);

				return redirect()->to('/');
			}

			$user->status = User::STATUS_PROCESSING_VERIFY;

			$contactHelper = new ContactHelper();
			if ($contactHelper->detectEmail($user->email))
			{
				dispatch(new VeryAccountJob($user))
					->onQueue('very-account')
					->delay(Carbon::now()->addMinutes(1));

				\Session::flash('toastr', [
					'type'    => 'success',
					'message' => 'Mời bạn kiểm tra email để xác nhận tài khoản'
				]);
				$user->save();

				return redirect()->to('/');

			}else {
				\Session::flash('toastr', [
					'type'    => 'error',
					'message' => 'Mời bạn cập nhật email để xác nhận tài khoản'
				]);

				return redirect()->route('get.user.update_info');
			}
		}

		\Session::flash('toastr', [
			'type'    => 'error',
			'message' => 'Xác nhận thất bại. Không tồn tại user xác nhận'
		]);

		return redirect()->to('/');
	}

	protected function getIdUser($token)
	{
		$hashids       = new Hashids('', 50, config('setting._token'));
		$userID = $hashids->decode($token);
		$userID = $userID[0] ?? 0;
		return $userID;
	}
}

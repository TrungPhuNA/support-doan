<?php

namespace App\Http\Controllers\Auth;

use App\HelpersClass\ContactHelper;
use App\Http\Controllers\Controller;
use App\Jobs\Account\VeryAccountJob;
use App\Mail\RegisterSuccess;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Socialite;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Mail;

class SocialAuthController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        try{
			$user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
			if (\Auth::loginUsingId($user->id))
			{
				$contactHelper = new ContactHelper();
				if ($contactHelper->detectEmail($user->email))
				{
					if ($user->status == User::STATUS_DEFAULT)
						dispatch(new VeryAccountJob($user))
							->onQueue('very-account')
							->delay(Carbon::now()->addMinutes(1));
				}

				return redirect()->route('get.user.dashboard');
			}
		}catch (\Exception $exception)
		{
			Log::error("[Login social ]".$exception->getMessage());
		}

		\Session::flash('toastr', [
			'type'    => 'error',
			'message' => 'Đăng nhập '. $social .' thất bại'
		]);

        return redirect()->route('get.register');
    }
}

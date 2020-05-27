<?php

namespace App\Jobs\Account;

use App\Mail\Account\ResetPasswordEmail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetPasswordJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	protected $user;

	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try {
			$token = $this->getTokenByEmail($this->user->email);
			if ($token){
				$link  = route('get.new_password', ['email' => $this->user->email, '_token' => $token]);
				\Mail::to($this->user->email)->send(new ResetPasswordEmail($link));
			}
		} catch (\Exception $exception) {
			\Log::error("[ResetPasswordJob] :" . $exception->getMessage());
		}
	}

	protected function getTokenByEmail($email)
	{
		return \DB::table('password_resets')
			->where([
				'email' => $email,
			])->first();
	}
}

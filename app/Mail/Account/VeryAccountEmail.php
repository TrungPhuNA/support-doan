<?php

namespace App\Mail\Account;

use App\Mail\RegisterSuccess;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VeryAccountEmail extends Mailable
{
    use Queueable, SerializesModels;

	private $user;
	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$link = route('get.very_account',[
			'_token'   => $this->user->slug,
		]);

		$this->updateStatusProcessVeryAccount();
		return $this->view('emails.email_register')->with([
			'name' => $this->user->name,
			'link' => $link
		]);
	}

	protected function updateStatusProcessVeryAccount()
	{
		$this->user->status = User::STATUS_PROCESSING_VERIFY;
		$this->user->save();
	}
}

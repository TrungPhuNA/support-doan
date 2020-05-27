<?php

namespace App\Mail\Account;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

	private $link;
	public function __construct($link)
	{
		$this->link = $link;
	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		return $this->view('emails.reset_password')
			->with([
				'link' => $this->link,
			]);
    }
}

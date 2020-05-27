<?php


namespace App\Jobs\System;

use App\Mail\System\SendEmailErrorsSystem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendErrorSystemToAdmin implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	protected $content;
	public function __construct($content)
	{
		$this->content = $content;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try {
			\Mail::to('phupt.humg.94@gmail.com')->send(new SendEmailErrorsSystem($this->content));
		} catch (\Exception $ex) {
			\Log::error("Error: SendEmailErrorsJob".$ex->getMessage());
		}
	}
}
<?php

namespace App\Jobs\Account;

use App\Mail\Account\VeryAccountEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VeryAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    	\Log::info("Send email very account :". $this->user->email);
    	try{
			\Mail::to($this->user->email)->send(new VeryAccountEmail($this->user));
		}catch (\Exception $exception)
		{
			\Log::error("[VeryAccountJob] :". $exception->getMessage());
		}

    }
}

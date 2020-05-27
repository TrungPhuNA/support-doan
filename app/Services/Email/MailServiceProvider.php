<?php


namespace App\Services\Email;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Config;

class MailServiceProvider extends ServiceProvider
{
	public function boot()
	{

	}

	public function register()
	{
		try{
			if (\Schema::hasTable('setting_email')) {
				$mail = DB::table('setting_email')->first();
				if ($mail) {
					$config = [
						'driver'   => $mail->mail_driver,
						'host'     => $mail->mail_host,
						'port'     => $mail->mail_port,
						'from'     => [
							'address' => $mail->mail_from_address,
							'name'    => $mail->mail_domain
						],
						'encryption' => 'tls',
						'sendmail' => '/usr/sbin/sendmail -bs',
						'username' => $mail->mail_username,
						'password' => $mail->mail_password,
					];
					Config::set('mail', $config);
				}
			}
		}catch (\Exception $exception){

		}
	}
}
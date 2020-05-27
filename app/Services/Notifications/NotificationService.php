<?php


namespace App\Services\Notifications;


use Carbon\Carbon;

class NotificationService
{
	public static function saveNotify($data, $type)
	{
		\DB::table('notifications')
			->insert([
				'type_notify' => $type,
				'data'        => $data,
				'created_at'  => Carbon::now()
			]);
	}
}
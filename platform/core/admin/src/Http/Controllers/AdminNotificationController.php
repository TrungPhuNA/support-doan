<?php


namespace Core\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Notification;

class AdminNotificationController extends Controller
{
	public function index()
	{
		$notifications = Notification::orderByDesc('id')
			->paginate(20);

		$viewData = [
			'notifications' => $notifications
		];

		return view('admin::notification.index', $viewData);
	}
}
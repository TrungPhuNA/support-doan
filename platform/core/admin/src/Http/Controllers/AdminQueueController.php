<?php


namespace Core\Admin\Http\Controllers;


use App\Http\Controllers\Controller;

class AdminQueueController extends Controller
{
	public function index()
	{
		$queues = \DB::table('jobs')
			->orderByDesc('id')
			->paginate(20);

		return view('admin::queue.index',compact('queues'));
	}

	public function restart()
	{
		\DB::table('jobs')->delete();
		return redirect()->back();
	}
}
<?php


namespace Core\Test\Http\Controllers;


use App\Events\DemoPusherEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PusherTestController extends Controller
{
	public function index()
	{
		return view('test::pusher.index');
	}

	public function submitMessages(Request $request)
	{
		event(new DemoPusherEvent('Xin chào. Tôi là Phan Trung Phú'));
		return redirect()->back();
	}

	public function renderView()
	{
		return view('test::pusher.success');
	}
}
<?php


namespace Core\Test\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Mail\Test\SendEmailTest;
use Illuminate\Http\Request;
use Mail;

class EmailTestController extends Controller
{
	public function index()
	{
		return view('test::email.index');
	}

	public function sendEmail(Request $request)
	{
		$data = [
			'name' => 'Hệ thống test'
		];

		Mail::to($request->email)->send(new SendEmailTest($data));
		return redirect()->back();
	}
}